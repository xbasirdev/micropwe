<?php

namespace App\Http\Controllers;

use App\CuestionarioPregunta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CuestionarioPreguntaController extends Controller
{

    public function index()
    {
        $cuestionarioPregunta = CuestionarioPregunta::all();
        return $this->successResponse($cuestionarioPregunta);
    }

    public function show($cuestionarioPregunta)
    {
        $cuestionarioPregunta = CuestionarioPregunta::findOrFail($cuestionarioPregunta);
        return $this->successResponse($cuestionarioPregunta);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:120',
            'email' => 'required',
            'destino' => 'required',
            'numero' => 'required',
            'landing' => 'required',
        ];

        $this->validate($request, $rules);
        $cuestionarioPregunta = CuestionarioPregunta::create($request->all());
        return $this->successResponse($cuestionarioPregunta);

    }

    public function update(Request $request, $cuestionarioPregunta)
    {
        $rules = [
            'pregunta' => 'required|max:120',
            'tipoPregunta_id' => 'required'
        ];

        $this->validate($request, $rules);
        $cuestionarioPregunta = CuestionarioPregunta::findOrFail($cuestionarioPregunta);
        $cuestionarioPregunta = $cuestionarioPregunta->fill($request->all());

        if ($cuestionarioPregunta->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cuestionarioPregunta->save();
        return $this->successResponse($cuestionarioPregunta);
    }


    public function destroy($cuestionarioPregunta)
    {

        $cuestionarioPregunta = CuestionarioPregunta::findOrFail($cuestionarioPregunta);
        $cuestionarioPregunta->delete();
        return $this->successResponse($cuestionarioPregunta);
    }


}