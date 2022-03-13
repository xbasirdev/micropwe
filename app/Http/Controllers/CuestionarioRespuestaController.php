<?php

namespace App\Http\Controllers;

use App\CuestionarioRespuesta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CuestionarioRespuestaController extends Controller
{

    public function index()
    {
        $cuestionarioRespuesta = CuestionarioRespuesta::all();
        return $this->successResponse($cuestionarioRespuesta);
    }

    public function show($cuestionarioRespuesta)
    {
        $cuestionarioRespuesta = CuestionarioRespuesta::findOrFail($cuestionarioRespuesta);
        return $this->successResponse($cuestionarioRespuesta);
    }

    public function store(Request $request)
    {
        $rules = [
            'pregunta_id' => 'required',
            'egresado_id' => 'required',
            'codigoVerificacion_id' => 'required',
            'fecha' => 'required',
            'respuesta' => 'required|max:240'
        ];

        $this->validate($request, $rules);
        $cuestionarioRespuesta = CuestionarioRespuesta::create($request->all());
        return $this->successResponse($cuestionarioRespuesta);

    }

    public function update(Request $request, $cuestionarioRespuesta)
    {
        $rules = [
            'pregunta_id' => 'required',
            'egresado_id' => 'required',
            'codigoVerificacion_id' => 'required',
            'fecha' => 'required',
            'respuesta' => 'required|max:240'
        ];

        $this->validate($request, $rules);
        $cuestionarioRespuesta = CuestionarioRespuesta::findOrFail($cuestionarioRespuesta);
        $cuestionarioRespuesta = $cuestionarioRespuesta->fill($request->all());

        if ($cuestionarioRespuesta->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cuestionarioRespuesta->save();
        return $this->successResponse($cuestionarioRespuesta);
    }


    public function destroy($cuestionarioRespuesta)
    {

        $cuestionarioRespuesta = CuestionarioRespuesta::findOrFail($cuestionarioRespuesta);
        $cuestionarioRespuesta->delete();
        return $this->successResponse($cuestionarioRespuesta);
    }


}