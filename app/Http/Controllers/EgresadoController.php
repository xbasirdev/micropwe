<?php

namespace App\Http\Controllers;

use App\Egresado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class EgresadoController extends Controller
{

    public function index(Request $request)
    {
        $users = User::with("egresado")->whereIn("cedula", $request->users)->get();
        return $this->successResponse($users);
    }

    public function changeNotificationStatus(Request $request)
    {
        $user = User::where("cedula", $request->id)->orWhere("correo", $request->id)->with("egresado")->first();
        $user->egresado()->update(["notificacion"=>$request->status=="1" ? true:false]);
        return $this->successResponse($user->egresado);
    }

}