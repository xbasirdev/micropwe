<?php

namespace App\Http\Controllers;

use App\BolsaTrabajo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\NewRegistrationInModulesOfInterestEvent;

class BolsaTrabajoController extends Controller
{

    public function index()
    {
        $bolsa_trabajo = BolsaTrabajo::all();
        return $this->successResponse($bolsa_trabajo);
    }

    public function show($bolsa_trabajo)
    {
        $bolsa_trabajo = BolsaTrabajo::findOrFail($bolsa_trabajo);
        return $this->successResponse($bolsa_trabajo);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:120',
            'user_id' => 'required',
            'empresa' => 'required',
            'vacantes' => 'required',
            'carrera_id' => 'required',
        ];

        $bolsa_trabajo = BolsaTrabajo::create($request->all());
        return $this->successResponse($bolsa_trabajo);

    }

    public function update(Request $request, $bolsa_trabajo)
    {
        $rules = [
            'nombre' => 'required|max:120',
            'user_id' => 'required',
            'empresa' => 'required',
            'vacantes' => 'required',
            'carreras' => 'required',
        ];

        //$this->validate($request, $rules);
        $bolsa_trabajo = BolsaTrabajo::findOrFail($bolsa_trabajo);
        $bolsa_trabajo = $bolsa_trabajo->fill($request->all());

        $bolsa_trabajo->save();
        return $this->successResponse($bolsa_trabajo);
    }


    public function destroy($bolsa_trabajo)
    {

        $bolsa_trabajo = BolsaTrabajo::findOrFail($bolsa_trabajo);
        $bolsa_trabajo->delete();
        return $this->successResponse($bolsa_trabajo);
    }


}