<?php

namespace App;

use App\Helpers\Image;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curso extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'titulo',
        'horas_cronologicas',
        'realizado',
        'fecha_inicio',
        'fecha_termino',
        'estado',
        'anio',
        'interno',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'fecha_inicio',
        'fecha_termino',
    ];

    public function colaboradores(): HasMany
    {
        return $this->hasMany('App\CursoColaborador');
    }

    /**
     * Get the tipo for the cursp.
     */
    public function tipoCurso(): BelongsTo
    {
        return $this->belongsTo('App\TipoCurso');
    }

    public function crearCapacitacion($colaborador, $file)
    {
        $cursoColaborador = CursoColaborador::make([
            'diploma' => is_string($file) ? base64_encode($file) : Image::convertImage($file),
        ]);

        $cursoColaborador->url_diploma = $this->saveFile($file, $colaborador);

        $cursoColaborador->curso()->associate($this->id);
        $cursoColaborador->colaborador()->associate($colaborador);
        $cursoColaborador->save();

        return true;
    }

    public function saveFile($file, $colaborador)
    {
        $colaborador = Colaborador::findOrFail($colaborador);

        if (is_string($file)) {
            $extension = 'pdf';
            $filePath = 'public/diplomas/'.$this->nombre.'_'.$colaborador->rut.'.'.$extension;
            Storage::put($filePath, $file);
        } else {
            $filePath = $file->storeAs(
                    'public/diplomas',
                    $this->nombre.'_'.$colaborador->rut.'.'.$file->extension()
                );
        }

        return $filePath;
    }

    public function generarPDFCapacitacion($IdColaborador)
    {
        $colaborador = Colaborador::findOrFail($IdColaborador);
        $pdf = PDF::loadView('capacitacion.diploma', [
            'colaborador' => $colaborador,
        ]);
        $content = $pdf->download()->getOriginalContent();

        return $content;
    }
}
