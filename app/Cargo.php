<?php

namespace App;

use App\Helpers\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cargo extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'estado',
        'descriptor',
        'descriptor_url',
        'organigrama',
        'organigrama_url',
        'nombre_fantasia'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the supervisor for the cargo.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo('App\Cargo', 'supervisor_id');
    }

    /**
     * Get the area for the cargo.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo('App\Area');
    }

    /**
     * Get the nivel jerarquico for the cargo.
     */
    public function nivelJerarquico(): BelongsTo
    {
        return $this->belongsTo('App\NivelJerarquico');
    }

    /**
     * Get the nivel jerarquico for the cargo.
     */
    public function movilidades(): HasMany
    {
        return $this->HasMany('App\Movilidad');
    }

    public function setDescriptorAttribute($descriptor)
    {
        $this->attributes['descriptor'] = $descriptor ? Image::convertImage($descriptor) : '';
    }

    public function setOrganigramaAttribute($organigrama)
    {
        $this->attributes['organigrama'] = $organigrama ? Image::convertImage($organigrama) : '';
    }

    public function encontrarCargoInferior()
    {
        $cargosHijos=self::where('supervisor_id', $this->id)->get();
        if($cargosHijos->where('estado',1)->count()){
            return true;
        }

        return false;
    }

    public function saveFile($file,$tipo)
    {
        $filePath = $file->storeAs(
                    'public/cargos',
                    $this->id.'_'.$this->nombre.'_'.$tipo.'.'.$file->extension()
                );
        return $filePath;
    }

    public function actualizarArchivo($request,$tipo)
    {
        $tipoUrl=$tipo.'_url';

        if ($request->file($tipo)) {
            $this->$tipoUrl = $this->saveFile($request->file($tipo),$tipo);
        } else {
            if (!$request->$tipoUrl && $this->$tipoUrl) {
                Storage::delete($this->$tipoUrl);
                $this->$tipo = null;
                $this->$tipoUrl = null;
            }
        }
    }
}
