<?php

namespace App\Http\Controllers;

use App\Evento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventoController extends Controller
{

    public function index()
    {
        $evento = Evento::all();
        return $this->successResponse($evento);
    }

    public function show($evento)
    {
        $evento = Evento::findOrFail($evento);
        return $this->successResponse($evento);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'titulo' => 'required|max:120',
            'descripcion' => 'required|max:255',
            'carreras' => 'max:120',
            'lugar' => 'required|max:120',
            'imagen' => 'max:255',
            'fecha' => 'max:255',
        ];

        $this->validate($request, $rules);
        $evento = Evento::create($request->all());
        return $this->successResponse($evento);

    }

    public function update(Request $request, $evento)
    {
        $rules = [
            'titulo' => 'max:120',
            'descripcion' => 'max:255',
            'carreras' => 'max:120',
            'lugar' => 'max:120',
            'imagen' => 'max:255',
            'fecha' => 'max:255',
        ];

        return $this->successResponse($request);

        $this->validate($request, $rules);
        $evento = Evento::findOrFail($evento);
        $evento = $evento->fill($request->all());

        if ($evento->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $evento->save();
        return $this->successResponse($evento);
    }


    public function destroy($evento)
    {

        $evento = Evento::findOrFail($evento);
        $evento->delete();
        return $this->successResponse($evento);
    }


}