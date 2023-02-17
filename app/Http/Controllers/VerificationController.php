<?php

namespace App\Http\Controllers;

use App\Verification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{

    public function index()
    {
        $verification = Verification::all();
        return $this->successResponse($verification);
    }

    public function show($verification)
    {
        $verificacion= \DB::table('verificacion')
        ->where('verificacion.codigo', $verification)
        ->leftJoin('cuestionario_respuesta', 'verificacion.id', 'cuestionario_respuesta.codigoVerificacion_id')
        ->leftJoin('users', 'cuestionario_respuesta.egresado_id', 'users.id')
        ->leftJoin('cuestionario_pregunta', 'cuestionario_respuesta.pregunta_id', 'cuestionario_pregunta.id')
        ->leftJoin('cuestionario', 'cuestionario_pregunta.cuestionario_id', 'cuestionario.id')
        ->select('cuestionario_respuesta.respuesta as respuesta',
        'cuestionario_respuesta.fecha as fecha',
        'cuestionario_pregunta.pregunta as pregunta',
        'cuestionario.nombre as cuestionario',
        'users.nombres as nombreEgresado',
        'users.apellidos as apellidoEgresado',
        'users.cedula as cedulaEgresado')
        ->get();
        
        return $this->successResponse($verificacion);
    }

    public function store(Request $request)
    {
        $rules = [
            'codigo' => 'required|max:120',
        ];

        $this->validate($request, $rules);
        $verification = Verification::create($request->all());
        return $this->successResponse($verification);

    }

    public function update(Request $request, $verification)
    {
        $rules = [
            'codigo' => 'max:120',
        ];

        $this->validate($request, $rules);
        $verification = Verification::findOrFail($verification);
        $verification = $verification->fill($request->all());

        if ($verification->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $verification->save();
        return $this->successResponse($verification);
    }


    public function destroy($verification)
    {

        $verification = Verification::findOrFail($verification);
        $verification->delete();
        return $this->successResponse($verification);
    }


}