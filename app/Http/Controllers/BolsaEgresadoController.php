<?php

namespace App\Http\Controllers;

use App\BolsaEgresado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BolsaEgresadoController extends Controller
{

    public function index()
    {
        $bolsa_egresado = BolsaEgresado::all();
        return $this->successResponse($bolsa_egresado);
    }

    public function show($bolsa_egresado)
    {
        $bolsa_egresado = BolsaEgresado::findOrFail($bolsa_egresado);
        return $this->successResponse($bolsa_egresado);
    }

    public function store(Request $request)
    {
        $rules = [
            'estado' => 'required',
        ];

        $this->validate($request, $rules);
        $bolsa_egresado = BolsaEgresado::create($request->all());
        return $this->successResponse($bolsa_egresado);

    }

    public function update(Request $request, $bolsa_egresado)
    {
        $rules = [
            'estado' => 'required',
        ];

        return $this->successResponse($request);

        $this->validate($request, $rules);
        $bolsa_egresado = BolsaEgresado::findOrFail($bolsa_egresado);
        $bolsa_egresado = $bolsa_egresado->fill($request->all());

        if ($bolsa_egresado->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $bolsa_egresado->save();
        return $this->successResponse($bolsa_egresado);
    }


    public function destroy($bolsa_egresado)
    {

        $bolsa_egresado = BolsaEgresado::findOrFail($bolsa_egresado);
        $bolsa_egresado->delete();
        return $this->successResponse($bolsa_egresado);
    }


}