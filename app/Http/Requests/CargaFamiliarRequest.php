<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
        $rules = [
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'fecha_nacimiento' => ['nullable', 'date', 'date_format:Y-m-d'],
            'estado' => ['required', 'boolean'],
            'tipo_carga_id' => ['required', 'exists:tipo_cargas,id'],
            'rut' => ['nullable',
            Rule::unique('cargas_familiares')
            ->ignore($this->id),
            'max:255', ],
        ];

        return $rules;
    }
}
