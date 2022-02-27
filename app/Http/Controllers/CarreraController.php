<?php

namespace App\Http\Controllers;

use App\Carrera;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarreraController extends Controller
{

    public function index()
    {
        $carrera = Carrera::all();
        return $this->successResponse($carrera);
    }

    public function show($carrera)
    {
        $carrera = Carrera::findOrFail($carrera);
        return $this->successResponse($carrera);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:120',
        ];

        $this->validate($request, $rules);
        $carrera = Carrera::create($request->all());
        return $this->successResponse($carrera);

    }

    public function update(Request $request, $carrera)
    {
        $rules = [
            'nombre' => 'max:120',
        ];

        return $this->successResponse($request);

        $this->validate($request, $rules);
        $carrera = Carrera::findOrFail($carrera);
        $carrera = $carrera->fill($request->all());

        if ($carrera->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $carrera->save();
        return $this->successResponse($carrera);
    }


    public function destroy($carrera)
    {

        $carrera = Carrera::findOrFail($carrera);
        $carrera->delete();
        return $this->successResponse($carrera);
    }


}