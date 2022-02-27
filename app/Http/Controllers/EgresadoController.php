<?php

namespace App\Http\Controllers;

use App\Egresado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EgresadoController extends Controller
{

    public function index()
    {
        $egresado = Egresado::all();
        return $this->successResponse($egresado);
    }

    public function show($egresado)
    {
        $egresado = Egresado::findOrFail($egresado);
        return $this->successResponse($egresado);
    }

    public function store(Request $request)
    {
        $rules = [
            'modo_registro' => 'required',
            'nombres' => 'required|max:120',
            'apellidos' => 'required|max:120',
            'cedula' => 'required|max:120',
            'correo' => 'required',
            'periodo_egreso' => 'required|max:120',
        ];

        $this->validate($request, $rules);
        $egresado = Egresado::create($request->all());
        return $this->successResponse($egresado);

    }

    public function update(Request $request, $egresado)
    {
        $rules = [
            'modo_registro' => 'required',
            'nombres' => 'required|max:120',
            'apellidos' => 'required|max:120',
            'cedula' => 'required|max:120',
            'correo' => 'required',
            'periodo_egreso' => 'required|max:120',
        ];

        return $this->successResponse($request);

        $this->validate($request, $rules);
        $egresado = Egresado::findOrFail($egresado);
        $egresado = $egresado->fill($request->all());

        if ($egresado->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $egresado->save();
        return $this->successResponse($egresado);
    }


    public function destroy($egresado)
    {

        $egresado = Egresado::findOrFail($egresado);
        $egresado->delete();
        return $this->successResponse($egresado);
    }


}