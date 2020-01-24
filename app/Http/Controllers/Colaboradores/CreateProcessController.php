<?php

namespace App\Http\Controllers\Colaboradores;

use App\Movilidad;
use App\Colaborador;
use Freshwork\ChileanBundle\Rut;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ColaboradorRequest;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class CreateProcessController extends Controller
{
    public function __invoke(ColaboradorRequest $request)
    {
        if (!(Rut::parse($request->rut)->quiet()->validate())) {
            return response()->json(['message' => 'El rut es inválido.'], 409);
        }

        $colaborador = $this->instanciarColaborador($request);

        $colaborador->nivelEducacion()->associate($request->nivel_educacion_id);
        $colaborador->estadoCivil()->associate($request->estado_civil_id);
        $colaborador->save();

        if ($request->cargo_id) {
            // $movilidad = Movilidad::make([
            //                 'fecha_inicio' => $request->fecha_inicio,
            //             ]);
            // $movilidad->colaborador()->associate($colaborador->id);
            // $movilidad->cargo()->associate($request->cargo_id);
            // $movilidad->save();
        }

        $colaborador->tags()->sync($request->tags);

        return response()->json(null, 201);
    }

    public function instanciarColaborador($request)
    {
        $colaborador = Colaborador::make($request->validated());

        $colaborador->rut = $request->rut;
        $colaborador->password = Hash::make($request->password);
        
        
        if($request->file('imagen')){
            $finalURL=storage_path().'/app/public/colaboradores/imagenes/'.$request->rut.'.'.$request->file('imagen')->extension();
            $imagenReducida=Image::make(file_get_contents($request->file('imagen')->getRealPath()))
                            ->save($finalURL,75);
            // dd(Storage::url('public/colaboradores/imagenes/'.$request->rut.'.'.$request->file('imagen')->extension()));
            $colaborador->imagen_url = url(Storage::url('public/colaboradores/imagenes/'.$request->rut.'.'.$request->file('imagen')->extension()));
        }        

        return $colaborador;
    }
}
