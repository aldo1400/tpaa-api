<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CargoRequest extends FormRequest
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
            'nivel_jerarquico' => ['required', 'in:Estratégico Táctico,Operativo Supervisión,Táctico Operativo,Táctico,Ejecución'],
            'nombre' => ['required', 'string'],
            'supervisor_id' => ['nullable', 'exists:cargos,id'],
        ];
    }
}
