<?php

namespace App\Http\Controllers;

use App\ActividadExtension;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActividadExtensionController extends Controller
{

    public function index()
    {
        $actividad_extension = ActividadExtension::all();
        return $this->successResponse($actividad_extension);
    }

    public function show($actividad_extension)
    {
        $actividad_extension = ActividadExtension::findOrFail($actividad_extension);
        return $this->successResponse($actividad_extension);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'titulo' => 'required|max:120',
            'descripcion' => 'required|max:255',
            'carrera' => 'required|max:120',
            'tipo' => 'required|max:120',
            'imagen' => 'max:255',
            'periodo' => 'max:255',
        ];

        $this->validate($request, $rules);
        $actividad_extension = ActividadExtension::create($request->all());
        return $this->successResponse($actividad_extension);

    }

    public function update(Request $request, $actividad_extension)
    {
        $rules = [
            'titulo' => 'max:120',
            'descripcion' => 'max:255',
            'carrera' => 'max:120',
            'tipo' => 'max:120',
            'imagen' => 'max:255',
            'periodo' => 'max:255',
        ];

        return $this->successResponse($request);

        $this->validate($request, $rules);
        $actividad_extension = ActividadExtension::findOrFail($actividad_extension);
        $actividad_extension = $actividad_extension->fill($request->all());

        if ($actividad_extension->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $actividad_extension->save();
        return $this->successResponse($actividad_extension);
    }


    public function destroy($actividad_extension)
    {

        $actividad_extension = ActividadExtension::findOrFail($actividad_extension);
        $actividad_extension->delete();
        return $this->successResponse($actividad_extension);
    }


}