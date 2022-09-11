<?php

namespace App\Http\Controllers;

use App\Egresado;
use App\Exports\UserExport;
use App\Imports\UserImport;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    public function index()
    {
        $user = User::all();
        return $this->successResponse($user);
    }

    public function show($user)
    {
        $user = User::findOrFail($user);
        return $this->successResponse($user);
    }

    public function store(Request $request)
    {

        $rules = [
            'nombres' => 'required|max:120',
            'apellidos' => 'required|max:255',
            'cedula' => 'required|max:120',
            'telefono' => 'required|max:120',
            "correo" => "email|required|unique:users,correo",
            "user_id" => "nullable|exists:users,id",
        ];
        if (!$request->es_administrador) {
            $rules += [
                "modo_registro" => "string|required",
                "correo_personal" => "email|required|unique:egresado,correo",
                "periodo_egreso" => "string|required",
                "fecha_egreso" => "nullable",
                "carrera_id" => "integer|required|exists:carrera,id",
                "notificacion" => "boolean|required",
            ];
        }

        $this->validate($request, $rules);

        $user = User::create([
            "correo" => $request->correo,
            "user_id" => $request->user_id ?? null,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
        ]);

        if (!$request->es_administrador) {
            $egresado = Egresado::create([
                "user_id" => $user->id,
                "modo_registro" => $request->modo_registro,
                "correo" => $request->correo_personal,
                "periodo_egreso" => $request->periodo_egreso,
                "fecha_egreso" => $request->fecha_egreso,
                "carrera_id" => $request->carrera_id,
                "notificacion" => $request->notificacion,
            ]);
        }

        return $this->successResponse($user);

    }

    public function update(Request $request, $user)
    {
        $rules = [
            'titulo' => 'max:120',
            'descripcion' => 'max:255',
            'carrera' => 'max:120',
            'tipo' => 'max:120',
            'imagen' => 'max:255',
            'periodo' => 'max:255',
        ];

        $this->validate($request, $rules);
        $user = User::findOrFail($user);
        $user = $user->fill($request->all());

        if ($user->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();
        return $this->successResponse($user);
    }

    public function destroy($user)
    {

        $user = User::findOrFail($user);
        $user->delete();
        return $this->successResponse($user);
    }

    public function export(Request $request)
    {
        $users = User::whereIn("cedula", $request->users)->get();
        $ext = $request->base_format;
        $title = "usuarios-" . Carbon::now()->format("yymdhms") . '.' . $ext;
        return Excel::download(new UserExport($users, $request->act_on), $title);
    }

    public function import(Request $request)
    {
      
        $base64File = $request->file_encode;
        $base64File = explode(',',  $base64File);
        $ext = explode("/", $base64File[0]);
        $ext = ".".str_replace(";base64","",$ext[2]);
        // decode the base64 file
        $fileData = base64_decode($base64File[1]);

        
        // save it to temporary dir first.
        $tmpFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . Carbon::now()->format("yymdhms").$ext;
        
        $file = file_put_contents($tmpFilePath, $fileData);

        // this just to help us get file info.
        $tmpFile = new File($tmpFilePath);

        $file = new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true// Mark it as test, since the file isn't from real HTTP POST.
        );
        
        // Determine si la extensión del archivo cumple con los requisitos
        $allowExtension = ['xls', 'xlsx', 'csv'];
        $fileExtension = $file->getClientOriginalExtension();
        
        if (!in_array($fileExtension, $allowExtension)) {
            return $this->errorResponse("El tipo de archivo no es valido, debe ingresar un archivo csv, xlsx o xls", 403);
        }
        
        $request["file"]=$file;
        $user = User::where("cedula", $request->user)->first();
        
        $user->import($request);
        
        if (!empty($user->errors())) {
            return $this->errorResponse(["message" => "Error al importar: ", "messages" => $user->errors()], 403);
        }

        Excel::import(new UserImport($user, $request->act_on), $file);
        
        if (!empty($user->errors())) {
            return $this->errorResponse(["message" => "Error al importar: ", "messages" => $user->errors()], 403);
        }

        return $this->successResponse(["new_users" => $user->newUsers()]);
    }
}
