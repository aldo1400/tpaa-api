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
            'nombre' => ['required', 'string'],
            'estado' => ['required', 'boolean'],
            'supervisor_id' => ['nullable', 'exists:cargos,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'nivel_jerarquico_id' => ['required', 'exists:niveles_jerarquico,id'],
        ];
    }
}
