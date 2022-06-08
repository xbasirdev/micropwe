<?php

namespace App\Http\Controllers;

use App\Cuestionario;
use App\ObjetivoCuestionario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CuestionarioController extends Controller
{

    public function index()
    {
        $cuestionario = Cuestionario::all();
        return $this->successResponse($cuestionario);
    }

    public function show($cuestionario)
    {
        $cuestionario = Cuestionario::findOrFail($cuestionario);
        return $this->successResponse($cuestionario);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:120',
            'descripcion' => 'required|max:240',
            'tipo' => 'required|max:60',
            'privacidad' => 'required'
        ];

        $this->validate($request, $rules);
        $cuestionario = Cuestionario::create($request->all());
        $carrerasArray = explode(',', $request->objetivo);
        foreach ($carrerasArray as $carrera){
            $carreraGuardada = ObjetivoCuestionario::create([
                'carrera_id' => $carrera,
                'cuestionario_id' => $cuestionario->id,
            ]);
        }
        return $this->successResponse($cuestionario);

    }

    public function update(Request $request, $cuestionarioID)
    {
        $rules = [
            'nombre' => 'required|max:120',
            'descripcion' => 'required|max:240',
            'tipo' => 'required|max:60',
            'privacidad' => 'required'
        ];

        $this->validate($request, $rules);
        $cuestionario = Cuestionario::findOrFail($cuestionarioID);
        $cuestionario = $cuestionario->fill($request->all());

        if ($cuestionario->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cuestionario->save();
        $deleted = DB::table('objetivo_cuestionario')->where('cuestionario_id', '=', $cuestionarioID)->delete();
        $carrerasArray = explode(',', $request->objetivo);
        foreach ($carrerasArray as $carrera){
            $carreraGuardada = ObjetivoCuestionario::create([
                'carrera_id' => $carrera,
                'cuestionario_id' => $cuestionario->id,
            ]);
        }
        return $this->successResponse($cuestionario);
    }


    public function destroy($cuestionario)
    {

        $cuestionario = Cuestionario::findOrFail($cuestionario);
        $cuestionario->delete();
        return $this->successResponse($cuestionario);
    }


}