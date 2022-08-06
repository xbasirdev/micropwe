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
            'fecha' => 'max:255',
        ];

        $this->validate($request, $rules);

        if ($request->hasFile('img')) {
            $image      = $request->file('img');
            $destination = "images/";
            $fileName   = time() . '.' . $image->getClientOriginalExtension();
            $imagenSubida = $request->file("img")->move($destination, $fileName);
            $request->merge(['imagen' => $destination . $fileName]);
        }

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
            'fecha' => 'max:255',
        ];

        if ($request->hasFile('img')) {
            $image      = $request->file('img');
            $destination = "images/";
            $fileName   = time() . '.' . $image->getClientOriginalExtension();
            $imagenSubida = $request->file("img")->move($destination, $fileName);
            $request->merge(['imagen' => $destination . $fileName]);
        }

        $evento = Evento::findOrFail($evento);
        $evento = $evento->fill($request->all());

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