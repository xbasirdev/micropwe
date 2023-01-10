<?php

namespace App\Http\Controllers;

use App\BancoPregunta;
use App\CuestionarioPregunta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BancoPreguntaController extends Controller
{

    public function index()
    {
        $bancoPregunta = BancoPregunta::all();
        return $this->successResponse($bancoPregunta);
    }

    public function show($bancoPregunta)
    {
        //$bancoPregunta = BancoPregunta::findOrFail($bancoPregunta);
        $bancoPreguntas = \DB::table('banco_pregunta')
        ->where('banco_pregunta.banco_id', $bancoPregunta)
        ->Join('cuestionario_pregunta', 'banco_pregunta.pregunta_id', 'cuestionario_pregunta.id')
        ->Join('tipo_pregunta', 'cuestionario_pregunta.tipoPregunta_id', 'tipo_pregunta.id')
        ->get();
        return $this->successResponse($bancoPreguntas);
    }

    public function store(Request $request)
    {
        $bancoCuestionarioPregunta = CuestionarioPregunta::create($request->all());
        $requesteAux = $request->all();
        $requesteAux['pregunta_id'] = $bancoCuestionarioPregunta->id;
        $bancoPregunta = BancoPregunta::create($requesteAux);
        return $this->successResponse($bancoPregunta);

    }

    public function update(Request $request, $bancoPregunta)
    {
        $bancoPregunta = BancoPregunta::findOrFail($bancoPregunta);
        $bancoPregunta = $bancoPregunta->fill($request->all());

        if ($bancoPregunta->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $bancoPregunta->save();
        return $this->successResponse($bancoPregunta);
    }


    public function destroy($bancoPregunta)
    {

        $bancoPregunta = BancoPregunta::findOrFail($bancoPregunta);
        $bancoPregunta->delete();
        return $this->successResponse($bancoPregunta);
    }


}