<?php

namespace App\Http\Controllers;

use App\OpcionPregunta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OpcionPreguntaController extends Controller
{

    public function index()
    {
        $opcionPregunta = OpcionPregunta::all();
        return $this->successResponse($opcionPregunta);
    }

    public function show($opcionPregunta)
    {
        $opcionPregunta = OpcionPregunta::findOrFail($opcionPregunta);
        return $this->successResponse($opcionPregunta);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:120',
            'pregunta_id' => 'required'
        ];

        $this->validate($request, $rules);
        $opcionPregunta = OpcionPregunta::create($request->all());
        return $this->successResponse($opcionPregunta);

    }

    public function update(Request $request, $opcionPregunta)
    {
        $rules = [
            'nombre' => 'max:120',
            'pregunta_id' => 'required'
        ];

        $this->validate($request, $rules);
        $opcionPregunta = OpcionPregunta::findOrFail($opcionPregunta);
        $opcionPregunta = $opcionPregunta->fill($request->all());

        if ($opcionPregunta->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $opcionPregunta->save();
        return $this->successResponse($opcionPregunta);
    }


    public function destroy($opcionPregunta)
    {

        $opcionPregunta = OpcionPregunta::findOrFail($opcionPregunta);
        $opcionPregunta->delete();
        return $this->successResponse($opcionPregunta);
    }


}