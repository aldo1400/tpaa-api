<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComentarioRequest extends FormRequest
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
            'texto_libre' => ['nullable', 'string'],
            'publico' => ['required', 'boolean'],
            'fecha' => ['nullable', 'date', 'date_format:Y-m-d'],
            'estado' => ['nullable', 'boolean'],
            'colaborador_id' => ['required', 'exists:colaboradores,id'],
            'colaborador_autor_id' => ['required', 'exists:colaboradores,id'],
            'tipo_comentario_id' => ['required', 'exists:tipos_comentario,id'],
        ];
    }
}
