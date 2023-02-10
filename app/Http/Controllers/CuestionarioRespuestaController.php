<?php

namespace App\Http\Controllers;

use App\CuestionarioRespuesta;
use App\Verification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

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
        $codigoVer = $request[0]['cuestionario_id'].'E'.$request[0]['egresado_id'].'V';
        $codVerFinal = Verification::create([
            'codigo' => $codigoVer
        ]);
        for($i = 0; $i < count($request->all()); $i++){
            if(is_array($request[$i]['respuesta'])){
                foreach ($request[$i]['respuesta'] as $answer){
                    CuestionarioRespuesta::create([
                        'pregunta_id' => $request[$i]['pregunta_id'],
                        'egresado_id' => intval($request[$i]['egresado_id']),
                        'fecha' => Carbon::now(),
                        'respuesta' => $answer,
                        'codigoVerificacion_id' => $codVerFinal->id
                    ]);
                }
            }else{
                CuestionarioRespuesta::create([
                    'pregunta_id' => $request[$i]['pregunta_id'],
                    'egresado_id' => intval($request[$i]['egresado_id']),
                    'fecha' => Carbon::now(),
                    'respuesta' => $request[$i]['respuesta'],
                    'codigoVerificacion_id' => $codVerFinal->id
                ]);
            }
        }
        return $this->successResponse($codVerFinal);

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