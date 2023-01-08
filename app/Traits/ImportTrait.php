<?php

namespace App\Traits;

use Maatwebsite\Excel\HeadingRowImport;
use Validator;
use App\User;
use App\Egresado;
use App\Carrera;
use \Illuminate\Support\Str;
trait ImportTrait
{
    protected $act_on;
    protected $action;
    protected $errors = [];
    protected $line;
    protected $user_empty_lines;
    protected $validator_fails = [];
    protected $new_user = [];

    public function import($request)
    {
        // Obtener objeto de archivo
        $this->action = $request->action;
        $file = $request->file;
        $this->act_on = $request->act_on;

        //Obtener el encabezado de Excel
        $headings = (new HeadingRowImport)->toArray($file);

        //si tiene columnas repetidas
        $repetido =array_diff_assoc($headings[0][0], array_unique($headings[0][0]));
        if (!empty($repetido)) {
            array_push($this->validator_fails, 'El archivo cargado posee los siguientes nombres de columnas repetidos: '. str_replace("_"," ", implode(", ",$repetido)));
            return;
        }
        $cant = count(array_filter($headings[0][0]));
        //Si encabezado del titulo trae menos de cinco elementos
        if (($this->act_on=="administrator" && !($cant == 5 || $cant == 6 )) || 
            ($this->act_on=="graduate" && !($cant == 6 || $cant ==7))) {
            array_push($this->validator_fails, 'El archivo cargado no posee la cantidad de columnas requerida');
            return;
        }

        //Si encabezado del titulo es vacio
        if (count(array_filter($headings[0][0])) === 0) {
            array_push($this->validator_fails, 'El archivo cargado posee nombres de columnas vacio');
            return;
        }

        // Determinar no trae ni titulo ni sku
        if (!in_array("nombres", $headings[0][0]) &&
            !in_array("apellidos", $headings[0][0]) &&
            !in_array("cedula", $headings[0][0]) &&
            !in_array("telefono", $headings[0][0]) &&
            !in_array("correo", $headings[0][0])) {
                if($this->act_on!="graduate"){
                    array_push($this->validator_fails, 'El archivo cargado no posee todas las columnas requeridas para registrar usuarios: nombres, apellidos, cedula, telefono, correo'); 
                }
                if($this->act_on=="graduate" &&  !in_array("periodo_egreso", $headings[0][0]) && !in_array("carrera", $headings[0][0])){
                    array_push($this->validator_fails, 'El archivo cargado no posee todas las columnas requeridas para registrar egresados: nombres, apellidos, cedula, telefono, correo, periodo de egreso, carrera'); 
                }                                  
            return;
        }
        return;
    }

    public function verifyEmptyColumn($query)
    {
        if (!empty($query["nombres"]) && !empty($query["apellidos"]) && !empty($query["cedula"]) && !empty($query["telefono"]) && !empty($query["correo"])) {
            if ($this->act_on == "graduate") {
                if (!empty($query["periodo_de_egreso"]) && !empty($query["carrera"])) {
                    return true;
                }
                return false;
            }
            return true;
        }
        return false;
    }

    //acciones sobre usuarios
    public function actionsOnUser($query, $line)
    {
        $this->line =$line;
        if(!$this->verifyEmptyColumn($query)){
            $this->user_empty_lines .= $line . ', ';
            return;
        }
        
        $user = User::where('cedula', $query['cedula'])->first();
        switch ($this->action) {
            //crear y actualizar usuarios
            case 'update_and_create':
                if (!empty($user)) {
                    $this->updateUser($query, $user);
                } else {
                    $this->createUser($query);
                }
                break;
            //solo actualizar usuarios
            case 'only_update':
                if (!empty($user)) {
                    $this->updateUser($query, $user);
                }
                break;
            //solo crear usuarios
            case 'only_create':
                if (empty($user)) {
                    $this->createUser($query);
                }
                break;
            default:
                array_push($this->validator_fails, 'Accion a ejecutar sobre los usuarios no es valida'. $this->action);
                break;
        }
        return;
    }

    public function errors($err = null)
    {
        if (!empty($err)) {
            $this->errors += [$err];

        }
        if (!empty($this->user_empty_lines)) {
            $this->errors += ["El archivo posee campos requeridos vacios en la linea ".  $this->user_empty_lines];
        }

        if (!empty($this->no_title_found)) {
            $this->errors += [trans('no_title_found', ['row' => $this->no_title_found])];
        }
        if (!empty($this->validator_fails)) {
            $this->errors += $this->validator_fails;
        }

        if (empty($err)) {
            return $this->errors;
        }
    }

    public function newUsers()
    {
        return $this->new_user ?? [];
    }

    //validar Datos a importar
    public function validator($row, $action = 'create')
    {
   
        $rules = [
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'telefono' => array("nullable","string","regex:/0(2(12|3[4589]|4[0-9]|[5-8][1-9]|9[1-5])|(4(12|14|16|24|26)))-?[0-9]{7}$/"),
        ];

        if ($this->act_on == "graduate") {
           $rules +=[
                "periodo_egreso"=>array("required","regex:/^[12][0-9]{3}[-][1-9]{1}$/"),
                "fecha_egreso"=>"nullable|date",
                "carrera"=>"integer|required|exists:carrera,id",
                "notificacion"=>"nullable|required",
           ];
        }
        
        if ($action == 'create') {
            $rules += [
                "correo"=>"email|required|unique:users,correo",
                "cedula"=>"required|unique:users,cedula"
            ];
            if ($this->act_on == "graduate") {    
                $rules +=[
                    "correo_personal"=>"email|required|unique:egresado,correo",
                ];
            }
        }
        if ($action == 'update') {
            $rules += [
                'correo' => 'required|email|unique:users,correo,'.$row["user"]->id,
                "cedula"=> array('required','string','unique:users,cedula,'.$row["user"]->id,'regex:/[VvEe]-[0-9]{6,}$/'),
            ];
            if ($this->act_on == "graduate") {
                $rules += [
                    'correo_personal' => 'required|email|unique:egresado,correo,'.$row["user"]->egresado->id,
                ];
            }    
        }    
          
        
        $validator = Validator::make($row, $rules);

        if ($validator->fails()) {
            $message = $validator->errors();
            $err = 'Error en la linea: '. $this->line ." del archivo. ";
            foreach ($message->messages() as $key => $value) {
                $err .= implode(", ", ($value));
            }
            array_push($this->validator_fails, $err);
            return false;
        }

        return true;
    }

    //crear usuarios
    public function createUser($query)
    {
        if ($this->validator($query, 'create')) {
            $user = User::create([
                'nombres'=>$query["nombres"],
                'apellidos'=>$query["apellidos"],
                'cedula'=>$query["cedula"],
                'telefono'=>$query["telefono"],
                'correo'=>$query["correo"],
                'user_id'=>$this->id,
            ]);
            if ($this->act_on == "graduate") {
                $query["carrera"] = Carrera::where("nombre", $query["carrera"])->first()->id;
                if(!empty($query["fecha_de_egreso"])){
                    $query["fecha_de_egreso"] = Carbon::parse($query["fecha_de_egreso"])->utc()->toDateTimeString();
                }
                $egresado =Egresado::create([
                    'user_id'=>$user->id,
                    'modo_registro' =>"Exportado",
                    'correo'=>$query["correo_personal"],
                    'periodo_egreso'=>$query["periodo_de_egreso"],
                    'fecha_egreso'=>$query["fecha_de_egreso"],
                    'notificacion'=>$query["notificaciones_activas"],
                    'carrera_id'=>$query["carrera"],
                ]); 
            }
            array_push($this->new_user, ["new_user"=>true, "cedula"=>$user->cedula, "correo"=>$user->correo, "nombres"=>$user->nombres, "apellidos"=>$user->apellidos]);
        }
    }

    //actualizar usuarios
    public function updateUser($query, $user)
    {  
         $query['id'] = $user->id;
        $query['user'] = $user;
        
        if ($this->validator($query, 'update')) {
            $user->update([
                'nombres'=>$query["nombres"],
                'apellidos'=>$query["apellidos"],
                'cedula'=>$query["cedula"],
                'telefono'=>$query["telefono"],
                'correo'=>$query["correo"]
            ]);

            if ($this->act_on == "graduate") {
                $query["carrera"] = Carrera::where("nombre", $query["carrera"])->first()->id;
                $user->egresado->update([
                    'correo'=>$query["correo_personal"],
                    'periodo_egreso'=>$query["periodo_de_egreso"],
                    'fecha_egreso'=>$query["fecha_de_egreso"],
                    'notificacion'=>$query["notificaciones_activas"],
                    'carrera_id'=>$query["carrera"],
                ]);
            }
            array_push($this->new_user, ["new_user"=>false, "change_role"=>$query["cambiar_rol"] ?? false, "cedula"=>$user->cedula, "correo"=>$user->correo, "nombres"=>$user->nombres, "apellidos"=>$user->apellidos]);
        }
    }
}
