<?php

namespace App\Http\Controllers;

use App\ActoGrado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\NewRegistrationInModulesOfInterestEvent;

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
        try {
            $users = usuariosEgresadosConNotificacionesActivas();
            if(!empty($users)){
                $url = env("APP_URL_FRONT", "http://localhost:4200");
                $message = "Esta disponible un nuevo acto de grado";
                $title = "Acto de grado disponible";
                event(new NewRegistrationInModulesOfInterestEvent($users, $url, $message, $title));
            }
        } catch (\Throwable$th) {
            return $this->errorResponse( "Error al enviar correos: ". $th->getMessage(), 404);
        }
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
