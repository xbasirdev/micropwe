<?php

namespace App\Http\Controllers;

use App\Cuestionario;
use App\ObjetivoCuestionario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\CuestionarioRespuesta;
use App\Exports\ExportD;
use App\Exports\ExportR;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

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
        \DB::table('objetivo_cuestionario')
        ->where('cuestionario_id', $cuestionario)
        ->delete();
        $cuestionario = Cuestionario::findOrFail($cuestionario);
        $cuestionario->delete();
        return $this->successResponse($cuestionario);
    }

    
    public function exportD(Request $request, $cuestionario)
    {
        $cuestionario = Cuestionario::findOrFail($cuestionario);
        $ext = $request->base_format;
        $title = "datos-estadisticos-" . Carbon::now()->format("yymdhms") . '.' . $ext;
        return Excel::download(new ExportD($cuestionario, $request->all()), $title);
    }

    
    public function exportR(Request $request, $cuestionario)
    {
        $ext = $request->base_format;
        $cuestionario_respuesta =  CuestionarioRespuesta::whereHas("pregunta", function($query) use ($cuestionario){
            $query->where("cuestionario_id", $cuestionario);
        })->get();
        $title = "respuesta-" . Carbon::now()->format("yymdhms") . '.' . $ext;
        return Excel::download(new ExportR($cuestionario_respuesta), $title);
    }

}