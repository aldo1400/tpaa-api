<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentoRequest extends FormRequest
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
            'tipo' => ['required', 'in:Gerencia General,Gerencia,Subgerencia,Área,Subarea'],
            'nombre' => ['required', 'string'],
            'padre_id' => ['nullable', 'exists:departamentos,id'],
        ];
    }
}
