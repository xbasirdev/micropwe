<?php

namespace App\Http\Controllers;

use App\CuestionarioPregunta;
use App\OpcionPregunta;
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

        $cuestionarioPreguntas = \DB::table('cuestionario_pregunta')
        ->where('cuestionario_pregunta.cuestionario_id', $cuestionarioPregunta)
        ->Join('tipo_pregunta', 'cuestionario_pregunta.tipoPregunta_id', 'tipo_pregunta.id')
        ->select('cuestionario_pregunta.id as id',
                 'tipo_pregunta.id as tipo_pregunta_id',
                 'tipo_pregunta.nombre as nombre',
                 'tipo_pregunta.descripcion as descripcion',
                 'cuestionario_pregunta.pregunta as pregunta',
                 'cuestionario_pregunta.numPregunta as numPregunta')
        ->get();
        
        return $this->successResponse($cuestionarioPreguntas);
    }

    public function store(Request $request)
    {
        $cuestionarioPregunta = CuestionarioPregunta::create($request->all());
        //$bancoPregunta = BancoPregunta::create($requesteAux);
        $opcionesArray = explode(',', $request->opciones);

        foreach ($opcionesArray as $opcion){
            OpcionPregunta::create([
                'esperada' => 0,
                'nombre' => $opcion,
                'pregunta_id' => $cuestionarioPregunta->id,
            ]);
        }

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
        \DB::table('opcion_pregunta')
        ->where('pregunta_id',$cuestionarioPregunta)
        ->delete();

        \DB::table('cuestionario_pregunta')
        ->where('id',$cuestionarioPregunta)
        ->delete();

        return $this->successResponse(true);
    }
}