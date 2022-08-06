<?php

namespace App\Http\Controllers;

use App\ActoGrado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActoGradoController extends Controller
{

    public function index()
    {
        $acto_grado = ActoGrado::all();
        return $this->successResponse($acto_grado);
    }

    public function show($acto_grado)
    {
        $acto_grado = ActoGrado::findOrFail($acto_grado);
        return $this->successResponse($acto_grado);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'titulo' => 'required|max:120',
            'descripcion' => 'required|max:120',
            'fecha' => 'max:255',
        ];

        $this->validate($request, $rules);
        $acto_grado = ActoGrado::create($request->all());
        return $this->successResponse($acto_grado);

    }

    public function update(Request $request, $acto_grado)
    {
        $rules = [
            'titulo' => 'max:120',
            'descripcion' => 'max:120',
            'fecha' => 'max:255'
        ];

        $this->validate($request, $rules);
        $acto_grado = ActoGrado::findOrFail($acto_grado);
        $acto_grado = $acto_grado->fill($request->all());

        $acto_grado->save();
        return $this->successResponse($acto_grado);
    }


    public function destroy($acto_grado)
    {

        $acto_grado = ActoGrado::findOrFail($acto_grado);
        $acto_grado->delete();
        return $this->successResponse($acto_grado);
    }


}
