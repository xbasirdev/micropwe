<?php

namespace App\Http\Controllers;

use App\User;
use App\Egresado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

use Validator;

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
            "correo"=>"email|required|unique:users,correo",
            "user_id"=>"nullable|exists:users,id"
        ];
        if(!$request->es_administrador){  
            $rules +=[
                "modo_registro"=>"string|required",
                "correo_personal"=>"email|required|unique:egresado,correo",
                "periodo_egreso"=>"string|required",
                "fecha_egreso"=>"nullable",
                "carrera_id"=>"integer|required|exists:carrera,id",
                "notificacion"=>"boolean|required",
            ];
        }
        
        $this->validate($request, $rules);

        $user = User::create([
            "correo"=> $request->correo,
            "user_id"=> $request->user_id ?? null,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono
        ]);

        if(!$request->es_administrador){                        
            $egresado = Egresado::create([
                "user_id"=>$user->id,
                "modo_registro"=>$request->modo_registro,
                "correo"=>$request->correo_personal,
                "periodo_egreso"=>$request->periodo_egreso,
                "fecha_egreso"=>$request->fecha_egreso,
                "carrera_id"=>$request->carrera_id,
                "notificacion"=>$request->notificacion,
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
        switch ($request->act_on) {
            case 'administrator':
                $users = usuarioAdministrador();
            break;
            case 'graduate':
                $users = usuarioEgresado();
            break;
            default:
                $users = User::All();
            break;  
        }
        
        $ext = $request->base_format;
        $title = "usuarios-" . Carbon::now()->format("yymdhms").'.'. $ext;
        return Excel::download(new UserExport($users, $request->act_on), $title );
    }
/*
    public function import(Request $request)
    {
        return $this->successResponse($user);

        $url_menus = submenus($slug);

        //verificar si se envio el archivo
        if (!$request->hasFile('file')) {
            return redirect()->back()->withError(__('Select the file before sending it'));
        }

        // Obtener objeto de archivo
        $file = $request->file('file');

        //validar archivo e importar
        if ($file->isValid()) {
            // Determine si la extensión del archivo cumple con los requisitos
            $allowExtension = ['xls', 'xlsx', 'csv'];
            $fileExtension = $file->getClientOriginalExtension();
            if (!in_array($fileExtension, $allowExtension)) {
                return redirect()->back()->withError(__('The suffix of the file you uploaded is not supported, is supported ') . implode(',', $allowExtension));
            }
            $menu = $url_menus['menu'];
            if ($data != 'root') {
              $menu = $url_menus['menu'];
            } else {
                $menu = Menu::findBySlugOrId($data);
            }
            if ($slug == 'uncategorized') {
                $request['uncategorized'] = ProductGroup::findBySlugOrId('uncategorized');
            }
            $menu->import($request);

            if (!empty($menu->errors())) {
                return redirect()->back()->with('errors_import', $menu->errors());
            }
            
            Excel::import(new ProductImport($menu, $data), $file);

            if (!empty($menu->errors())) {
                return redirect()->back()->with('errors_import', $menu->errors());
            }
        }

        return redirect()->back()->withSuccess(__('Imported products'));
    }

*/
}