<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
            'nombre' => ['required', 'string'],
            'padre_id' => ['nullable', 'exists:areas,id'],
            'estado' => ['required', 'boolean'],
            'tipo_area_id' => ['required', 'exists:tipo_areas,id'],
        ];

        return $rules;
    }
}
