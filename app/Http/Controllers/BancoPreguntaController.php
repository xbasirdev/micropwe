<?php

namespace App\Http\Controllers;

use App\BancoPregunta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BancoPreguntaController extends Controller
{

    public function index()
    {
        $bancoPregunta = BancoPregunta::all();
        return $this->successResponse($bancoPregunta);
    }

    public function show($bancoPregunta)
    {
        $bancoPregunta = BancoPregunta::findOrFail($bancoPregunta);
        return $this->successResponse($bancoPregunta);
    }

    public function store(Request $request)
    {
        $bancoPregunta = BancoPregunta::create($request->all());
        return $this->successResponse($bancoPregunta);

    }

    public function update(Request $request, $bancoPregunta)
    {
        $bancoPregunta = BancoPregunta::findOrFail($bancoPregunta);
        $bancoPregunta = $bancoPregunta->fill($request->all());

        if ($bancoPregunta->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $bancoPregunta->save();
        return $this->successResponse($bancoPregunta);
    }


    public function destroy($bancoPregunta)
    {

        $bancoPregunta = BancoPregunta::findOrFail($bancoPregunta);
        $bancoPregunta->delete();
        return $this->successResponse($bancoPregunta);
    }


}