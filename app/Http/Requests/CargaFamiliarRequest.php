<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CargaFamiliarRequest extends FormRequest
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
            'rut' => ['required', 'cl_rut'],
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'fecha_nacimiento' => ['required', 'date', 'date_format:Y-m-d'],
            'estado' => ['required', 'boolean'],
            'tipo_carga_id' => ['required', 'exists:tipo_cargas,id'],
        ];
    }
}
