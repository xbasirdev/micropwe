<?php

namespace App\Http\Controllers;

use App\ObjetivoCuestionario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ObjetivoCuestionarioController extends Controller
{

    public function index()
    {
        $cuestionarioObjetivo = ObjetivoCuestionario::all();
        return $this->successResponse($cuestionarioObjetivo);
    }

    public function show($cuestionarioObjetivo)
    {
        //$carreras = ObjetivoCuestionario::where('cuestionario_id', $cuestionarioObjetivo);
        $carreras = \DB::table('objetivo_cuestionario')
        ->where('cuestionario_id',$cuestionarioObjetivo)
        ->get();

        $carrerasFinal = array();
        foreach ($carreras as $carrera){
            array_push($carrerasFinal, $carrera->carrera_id);
        }
        return $this->successResponse($carrerasFinal);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:120',
            'carrera_id' => 'required'
        ];

        $this->validate($request, $rules);
        $cuestionarioObjetivo = ObjetivoCuestionario::create($request->all());
        return $this->successResponse($cuestionarioObjetivo);

    }

    public function update(Request $request, $cuestionarioObjetivo)
    {
        $rules = [
            'nombre' => 'max:120',
            'carrera_id' => 'required'
        ];

        $this->validate($request, $rules);
        $cuestionarioObjetivo = ObjetivoCuestionario::findOrFail($cuestionarioObjetivo);
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

        $cuestionarioObjetivo = ObjetivoCuestionario::findOrFail($cuestionarioObjetivo);
        $cuestionarioObjetivo->delete();
        return $this->successResponse($cuestionarioObjetivo);
    }


}