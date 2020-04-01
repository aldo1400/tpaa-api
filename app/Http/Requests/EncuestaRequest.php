<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncuestaRequest extends FormRequest
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
            'periodo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date', 'date_format:Y-m-d'],
            'fecha_fin' => ['required', 'date', 'date_format:Y-m-d'],
            'encuesta_facil_id' => ['required', 'string'],
            'encuesta_plantilla_id'=>['required','exists:encuesta_plantillas,id']
        ];
    }
}
