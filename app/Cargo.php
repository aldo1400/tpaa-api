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
        'nombre_fantasia',
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
        $this->attributes['descriptor'] = $descriptor ? is_string($descriptor) ? base64_encode($descriptor) : Image::convertImage($descriptor) : '';
    }

    public function setOrganigramaAttribute($organigrama)
    {
        $this->attributes['organigrama'] = $organigrama ? is_string($organigrama) ? base64_encode($organigrama) : Image::convertImage($organigrama) : '';
    }

    public function encontrarCargoInferior()
    {
        $cargosHijos = self::where('supervisor_id', $this->id)->get();
        if ($cargosHijos->where('estado', 1)->count()) {
            return true;
        }

        return false;
    }

    public function saveFile($file, $tipo)
    {
        $filePath = $file->storeAs(
                    'public/cargos',
                    $this->id.'_'.$this->nombre.'_'.$tipo.'.'.$file->extension()
                );

        return $filePath;
    }

    public function actualizarArchivo($request, $tipo)
    {
        $tipoUrl = $tipo.'_url';

        if ($request->file($tipo)) {
            $this->$tipoUrl = $this->saveFile($request->file($tipo), $tipo);
        } else {
            if (!$request->$tipoUrl && $this->$tipoUrl) {
                Storage::delete($this->$tipoUrl);
                $this->$tipo = null;
                $this->$tipoUrl = null;
            }
        }
    }

    public function generarArchivo($tipo)
    {
        // organigrama,descriptor
        $tipoURL = $tipo.'_url';
        // organigrama_url,descriptor_url
        if ($this->$tipo) {
            if (!(Storage::disk('local')->exists($this->$tipoURL))) {
                if ($this->$tipoURL) {
                    $url = $this->$tipoURL;
                // $url = 'public/cargos/'.$this->id.'_'.$this->nombre.'_organigrama'.'.'.$ext;
                } else {
                    $url = 'public/cargos/'.$this->id.'_'.$this->nombre.'_'.$tipo.'.pdf';
                }

                Storage::disk('local')
                        ->put($url, base64_decode($this->$tipo));

                $this->update([
                    $tipoURL => $url,
                ]);
            }
        } else {
            if ($this->$tipoURL) {
                $content = Storage::get($this->$tipoURL);
                if ($content) {
                    $this->update([
                        $tipo => $content,
                    ]);
                }
            }
        }
    }
}
