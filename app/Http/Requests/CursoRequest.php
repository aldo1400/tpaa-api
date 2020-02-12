<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'titulo' => ['required', 'string', 'max:255'],
            'horas_cronologicas' => ['required', 'numeric'],
            'realizado' => ['nullable', 'string'],
            'fecha_inicio' => ['nullable', 'date', 'date_format:Y-m-d'],
            'fecha_termino' => ['nullable', 'date', 'date_format:Y-m-d'],
            'estado' => ['required', 'boolean'],
            'anio' => ['nullable', 'string'],
            'interno' => ['nullable', 'boolean'],
            'estado' => ['required', 'boolean'],
            'tipo_curso_id' => ['required', 'exists:tipo_cursos,id'],
        ];
    }
}
