<?php

namespace App\Http\Controllers;

use App\TipoPregunta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoPreguntaController extends Controller
{

    public function index()
    {
        $tipoPreguntaPregunta = TipoPregunta::all();
        return $this->successResponse($tipoPreguntaPregunta);
    }

    public function show($tipoPreguntaPregunta)
    {
        $tipoPreguntaPregunta = TipoPregunta::findOrFail($tipoPreguntaPregunta);
        return $this->successResponse($tipoPreguntaPregunta);
    }

    public function store(Request $request)
    {
        $tipoPreguntaPregunta = TipoPregunta::create($request->all());
        return $this->successResponse($tipoPreguntaPregunta);

    }

    public function update(Request $request, $tipoPreguntaPregunta)
    {
        $tipoPreguntaPregunta = TipoPregunta::findOrFail($tipoPreguntaPregunta);
        $tipoPreguntaPregunta = $tipoPreguntaPregunta->fill($request->all());

        if ($tipoPreguntaPregunta->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $tipoPreguntaPregunta->save();
        return $this->successResponse($tipoPreguntaPregunta);
    }


    public function destroy($tipoPreguntaPregunta)
    {

        $tipoPreguntaPregunta = TipoPregunta::findOrFail($tipoPreguntaPregunta);
        $tipoPreguntaPregunta->delete();
        return $this->successResponse($tipoPreguntaPregunta);
    }


}