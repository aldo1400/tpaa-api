<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovilidadRequest extends FormRequest
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
            'fecha_termino' => ['nullable', 'date', 'date_format:Y-m-d'],
            'fecha_inicio' => ['required', 'date', 'date_format:Y-m-d'],
            'observaciones' => ['nullable', 'string', 'max:255'],
            // 'estado' => ['required', 'boolean'],
            'cargo_id' => ['nullable', 'exists:cargos,id'],
            'tipo_movilidad_id' => ['required', 'exists:tipo_movilidades,id'],
        ];
    }
}
