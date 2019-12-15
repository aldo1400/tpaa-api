<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColaboradorRequest extends FormRequest
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
            'rut' => ['required', 'unique:colaboradores,rut', 'max:255'],
            'usuario' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
            'nombres' => ['nullable', 'max:255'],
            'apellidos' => ['nullable', 'string'],
            'sexo' => ['nullable', 'string'],
            'nacionalidad' => ['nullable', 'string'],
            'estado_civil' => ['nullable', 'in:Casado (a),Soltero (a),Divorciado (a),Unión Civil'],
            'fecha_nacimiento' => ['nullable', 'date', 'date_format:Y-m-d'],
            'edad' => ['nullable', 'integer'],
            'email' => ['nullable', 'email'],
            'nivel_educacion' => ['nullable', 'string'],
            'domicilio' => ['nullable', 'string'],
            'licencia_b' => ['nullable', 'string', 'in:SI,NO,N/A'],
            'vencimiento_licencia_b' => ['nullable', 'date', 'date_format:Y-m-d'],
            'licencia_d' => ['nullable', 'string', 'in:SI,NO,N/A'],
            'vencimiento_licencia_d' => ['nullable', 'date', 'date_format:Y-m-d'],
            'carnet_portuario' => ['nullable', 'in:SI,NO,N/A'],
            'vencimiento_carnet_portuario' => ['nullable', 'date', 'date_format:Y-m-d'],
            'talla_calzado' => ['nullable', 'string'],
            'talla_chaleco' => ['nullable', 'string'],
            'talla_polera' => ['nullable', 'string'],
            'talla_pantalon' => ['nullable', 'string'],
            'fecha_ingreso' => ['nullable', 'date', 'date_format:Y-m-d'],
            'telefono' => ['nullable', 'string'],
            'celular' => ['nullable', 'string'],
            'anexo' => ['nullable', 'string'],
            'contacto_emergencia_nombre' => ['nullable', 'string'],
            'contacto_emergencia_telefono' => ['nullable', 'string'],
            'estado' => ['nullable', 'in:Activo (a),Desvinculado (a),Renuncia'],
            'fecha_inactividad' => ['nullable', 'date', 'date_format:Y-m-d'],
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
        ];
    }
}
