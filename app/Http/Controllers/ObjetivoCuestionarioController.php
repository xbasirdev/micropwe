<?php

namespace App\Http\Controllers;

use App\CuestionarioObjetivo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CuestionarioObjetivoController extends Controller
{

    public function index()
    {
        $cuestionarioObjetivo = CuestionarioObjetivo::all();
        return $this->successResponse($cuestionarioObjetivo);
    }

    public function show($cuestionarioObjetivo)
    {
        $cuestionarioObjetivo = CuestionarioObjetivo::findOrFail($cuestionarioObjetivo);
        return $this->successResponse($cuestionarioObjetivo);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:120',
            'carrera_id' => 'required'
        ];

        $this->validate($request, $rules);
        $cuestionarioObjetivo = CuestionarioObjetivo::create($request->all());
        return $this->successResponse($cuestionarioObjetivo);

    }

    public function update(Request $request, $cuestionarioObjetivo)
    {
        $rules = [
            'nombre' => 'max:120',
            'carrera_id' => 'required'
        ];

        $this->validate($request, $rules);
        $cuestionarioObjetivo = CuestionarioObjetivo::findOrFail($cuestionarioObjetivo);
        $cuestionarioObjetivo = $cuestionarioObjetivo->fill($request->all());

        if ($cuestionarioObjetivo->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cuestionarioObjetivo->save();
        return $this->successResponse($cuestionarioObjetivo);
    }


    public function destroy($cuestionarioObjetivo)
    {

        $cuestionarioObjetivo = CuestionarioObjetivo::findOrFail($cuestionarioObjetivo);
        $cuestionarioObjetivo->delete();
        return $this->successResponse($cuestionarioObjetivo);
    }


}