<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeriodoRequest extends FormRequest
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
            'year' => ['required', 'integer'],
            'detalle' => ['nullable', 'string'],
            'descripcion' => ['required', 'string'],
            'encuesta_plantilla_id' => ['required', 'exists:encuesta_plantillas,id'],
            'publicado' => ['required', 'boolean'],
        ];
    }
}
