<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoColaboradorRequest extends FormRequest
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
            // 'fecha'=>['required','date','date_format:Y-m-d'],
            // 'tipo_archivo'=>['required','string'],
            // 'estado'=>['required','boolean'],
            'diploma' => ['nullable', 'image', 'mimes:jpeg,bmp,png'],
            // 'url_diploma'=>['required','string'],
            // 'curso_id'=>['required','exists:cursos,id'],
            'colaboradores' => ['nullable', 'array'],
            'colaboradores.*' => ['nullable', 'distinct', 'exists:colaboradores,id'],
        ];
    }
}
