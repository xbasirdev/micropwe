<?php

namespace App\Http\Controllers;

use App\Banco;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BancoController extends Controller
{

    public function index()
    {
        $banco = Banco::all();
        return $this->successResponse($banco);
    }

    public function show($banco)
    {
        $banco = Banco::findOrFail($banco);
        return $this->successResponse($banco);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:120',
        ];

        $this->validate($request, $rules);
        $banco = Banco::create($request->all());
        return $this->successResponse($banco);

    }

    public function update(Request $request, $banco)
    {
        $rules = [
            'nombre' => 'max:120',
        ];

        $this->validate($request, $rules);
        $banco = Banco::findOrFail($banco);
        $banco = $banco->fill($request->all());

        if ($banco->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $banco->save();
        return $this->successResponse($banco);
    }


    public function destroy($banco)
    {
        \DB::table('banco_pregunta')
        ->where('banco_id',$banco)
        ->delete();
        $banco = Banco::findOrFail($banco);
        $banco->delete();
        return $this->successResponse($banco);
    }


}