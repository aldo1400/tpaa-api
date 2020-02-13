<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ColaboradorRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(ColaboradorRequest $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->fill($request->validated());

        if ($request->imagen) {
            Image::make(file_get_contents($request->file('imagen')->getRealPath()))
            ->encode($request->file('imagen')->extension(), 75);

            $colaborador->imagen_url = $colaborador->saveImage($request);
        } else {
            if (!$request->imagen_url && $colaborador->imagen_url) {
                $ext = pathinfo($colaborador->imagen_url, PATHINFO_EXTENSION);

                $urlPath = 'public/colaboradores/imagenes/'.$colaborador->rut.'.'.$ext;

                Storage::delete($urlPath);
                $colaborador->imagen = null;
                $colaborador->imagen_url = null;
            }
        }

        $colaborador->nivelEducacion()->associate($request->nivel_educacion_id);
        $colaborador->estadoCivil()->associate($request->estado_civil_id);
        $colaborador->save();

        $colaborador->tags()->sync($request->tags);

        $colaborador->actualizarFechaVencimiento('vencimiento_licencia_b');
        $colaborador->actualizarFechaVencimiento('vencimiento_licencia_d');
        $colaborador->actualizarFechaVencimiento('vencimiento_carnet_portuario');
        $colaborador->actualizarFechaVencimiento('vencimiento_credencial_vigilante');

        return response()->json();
    }
}
