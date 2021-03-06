<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ColaboradorRequest;

class CreateProcessController extends Controller
{
    public function __invoke(ColaboradorRequest $request)
    {
        $colaborador = $this->instanciarColaborador($request);

        $colaborador->nivelEducacion()->associate($request->nivel_educacion_id);
        $colaborador->estadoCivil()->associate($request->estado_civil_id);
        $colaborador->save();

        $colaborador->tags()->sync($request->tags);

        return response()->json(null, 201);
    }

    public function instanciarColaborador($request)
    {
        $colaborador = Colaborador::make($request->validated());

        $colaborador->rut = $request->rut;

        $colaborador->password = $request->password ? Hash::make($request->password) : '';

        $colaborador->estado = 0;

        if ($request->file('imagen')) {
            $finalURL = storage_path().'/app/public/colaboradores/imagenes/'.$request->rut.'.'.$request->file('imagen')->extension();
            $imagenReducida = Image::make(file_get_contents($request->file('imagen')->getRealPath()))
                            ->save($finalURL, 75);
            $colaborador->imagen_url = url(Storage::url('public/colaboradores/imagenes/'.$request->rut.'.'.$request->file('imagen')->extension()));
            $colaborador->imagen = $request->imagen;
        }

        return $colaborador;
    }
}
