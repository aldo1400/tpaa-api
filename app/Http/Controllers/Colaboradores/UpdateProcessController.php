<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ColaboradorRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(ColaboradorRequest $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->fill($request->validated());

        if ($request->imagen) {
            $colaborador->imagen_url = $colaborador->saveImage($request);
        } else {
            if ($request->image_url) {
                $colaborador->imagen_url = $colaborador->imagen_url;
            } else {
                $ext = pathinfo($colaborador->imagen_url, PATHINFO_EXTENSION);

                $urlPath = 'public/colaboradores/imagenes/'.$colaborador->rut.'.'.$ext;

                Storage::delete($urlPath);
                $colaborador->imagen = null;
                $colaborador->imagen_url = null;
            }
        }

        // $colaborador->imagen_url = $request->imagen ? $colaborador->saveImage($request) : $colaborador->imagen_url;
        $colaborador->nivelEducacion()->associate($request->nivel_educacion_id);
        $colaborador->estadoCivil()->associate($request->estado_civil_id);
        $colaborador->save();

        $colaborador->tags()->sync($request->tags);

        return response()->json();
    }
}
