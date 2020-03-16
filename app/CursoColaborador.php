<?php

namespace App;

use App\Helpers\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CursoColaborador extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cursos_colaborador';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diploma',
        'url_diploma',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get the supervisor for the cargo.
     */
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador');
    }

    /**
     * Get the supervisor for the cargo.
     */
    public function curso(): BelongsTo
    {
        return $this->belongsTo('App\Curso');
    }

    public function generarArchivoDeDiploma()
    {
        if ($this->diploma) {
            if (!(Storage::disk('local')->exists($this->url_diploma))) {
                if ($this->url_diploma) {
                    $url = $this->url_diploma;
                }
                Storage::disk('local')
                        ->put($url, base64_decode($this->diploma));

                $this->update([
                    'url_diploma' => $url,
                ]);
            }
        } else {
            if ($this->url_diploma) {
                $content = Storage::get($this->url_diploma);
                if ($content) {
                    $this->update([
                        'diploma' => base64_encode($content),
                    ]);
                }
            }
        }
    }

    public function actualizarArchivo($request, $tipo)
    {
        $tipoUrl = 'url_'.$tipo;

        if ($request->file($tipo)) {
            $this->$tipoUrl = $filePath = $request->file($tipo)->storeAs(
                'public/diplomas',
                $this->curso->nombre.'_'.$this->colaborador->rut.'.'.$request->file($tipo)->extension()
            );
            $this->diploma = Image::convertImage($request->file($tipo));
        // $this->saveFile($request->file($tipo), $tipo);
        } else {
            if (!$request->$tipoUrl && $this->$tipoUrl) {
                Storage::delete($this->$tipoUrl);
                $this->$tipo = null;
                $this->$tipoUrl = null;
            }
        }
    }
}
