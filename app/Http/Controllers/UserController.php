<?php

namespace App\Http\Controllers;

use App\Egresado;
use App\Exports\UserExport;
use App\Imports\UserImport;
use App\User;
use App\Carrera;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::whereIn("cedula", $request->users)->get();
        return $this->successResponse($users);
    }

    public function show($user)
    {
        $user = User::where('cedula', $user)->with(["egresado", "egresado.carrera"])->first();
        return $this->successResponse($user);
    }

    public function store(Request $request)
    {

        $rules = [
            "nombres"=>"required|string",
            "apellidos"=>"required|string",
            "telefono"=>array("nullable","string"),
            'correo' => 'required|email|unique:users,correo',
            'cedula' => array('required','string','unique:users,cedula','regex:/[VvEe]-[0-9]{6,}$/'),
            "form_type"=>"required",
            "user" => "required|exists:users,cedula",
        ];
        
        if($request->form_type == "graduate"){
            $rules += [
                "periodo_egreso"=>array("required","regex:/^[12][0-9]{3}[-][1-9]{1}$/"),
                "correo_personal"=>"nullable|email",
                "fecha_egreso"=>"nullable|date",
                "carrera"=>"required|exists:carrera,id",
            ];
        }
        
        $this->validate($request, $rules);
        
     
        $user_admin = User::where("cedula", $request->user)->first();        

        $user = User::create([
            "correo" => $request->correo,
            "user_id" => $user_admin->id,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cedula' => strtoupper($request->cedula),
            'telefono' => $request->telefono,
        ]);

        if($request->form_type == "graduate"){
            $carrera = Carrera::where("id", $request->carrera)->first();
            $egresado = Egresado::create([
                "user_id" => $user->id,
                "modo_registro" => 'Por formulario',
                "correo" => $request->correo_personal,
                "periodo_egreso" => $request->periodo_egreso,
                "fecha_egreso" => Carbon::parse($request->fecha_egreso)->utc()->toDateTimeString(),
                "carrera_id" => $carrera->id,
                "notificacion" => true,
            ]);
        }

        return $this->successResponse($user);
    }

    public function update(Request $request, $user)
    {
        $user = User::where("cedula", $user)->first();
        if( $request->role == "graduate" || $request->role == "administrator" ){
            $rules = [
                "nombres"=>"required|string",
                "apellidos"=>"required|string",
                "telefono"=>array("nullable","string"),
                'correo' => 'required|email|unique:users,correo,'.$user->id,
                'cedula' => array('required','string','unique:users,cedula,'.$user->id,'regex:/[VvEe]-[0-9]{6,}$/'),
                "form_type"=>"required",
            ];
        }
        if($request->form_type != "profile" && $request->role != "administrator" ){
            $rules += [
                "periodo_egreso"=>array("required","regex:/^[12][0-9]{3}[-][1-9]{1}$/"),
                "correo_personal"=>"nullable|email",
                "fecha_egreso"=>"nullable|date",
                "carrera"=>"required|exists:carrera,id",
            ];
        }

        if($request->form_type == "profile"){
            $rules = [
                "correo_personal"=>"nullable|email",
                "telefono"=>array("nullable","string"),
            ];
        }
        
        $this->validate($request, $rules);
        
        if($request->form_type == "profile"){
            $user->update(['telefono' => $request->telefono]);
            if($request->role == "graduate" ){
                $user->egresado->update(["correo" => $request->correo_personal]);
            }
        }else{
            
            $user_admin = User::where("cedula", $request->user)->first();
            $user->update([
                "correo" => $request->correo,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'cedula' => strtoupper($request->cedula),
                'telefono' => $request->telefono,
                "user_id"=>$user_admin->id,
            ]);

            if($request->form_type == "graduate"){
                $carrera = Carrera::where("id", $request->carrera)->first(); 
                $egresado =  Egresado::where(["user_id"=> $user->id])->first();
                
                if(empty($egresado)){
                    $egresado = Egresado::create([
                        "correo" => $request->correo_personal,
                        "periodo_egreso" => $request->periodo_egreso,
                        "fecha_egreso" => Carbon::parse($request->fecha_egreso)->utc()->toDateTimeString(),
                        "carrera_id" => $carrera->id,
                        "user_id" => $user->id,
                        "notificacion" => true,
                        "modo_registro" => 'Por formulario',
                    ]);
                }else{
                    $egresado->update([
                        "correo" => $request->correo_personal,
                        "periodo_egreso" => $request->periodo_egreso,
                        "fecha_egreso" => Carbon::parse($request->fecha_egreso)->utc()->toDateTimeString(),
                        "carrera_id" => $carrera->id,
                    ]);

                }
                
            }
        }
        
        return $this->successResponse($user);
    }

    public function destroy($user)
    {
        $user = User::where("cedula",$user)->first();
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

        return $this->successResponse(["message"=>"Archivo importado correctamente", "new_users" => $user->newUsers()]);
    }
}
