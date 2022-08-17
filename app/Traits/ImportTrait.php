<?php

namespace App\Traits;

use \Illuminate\Support\Str;
use App\Models\Menu;
use App\Models\MenuType;
use App\Models\Product;
use App\Models\ProductGroup;
use Maatwebsite\Excel\HeadingRowImport;
use Validator;
trait ImportTrait
{
    protected $type;
    protected $errors = [];
    protected $line;
    protected $user_empty_lines;
    protected $validator_fails = [];

    public function import($request)
    {
        // Obtener objeto de archivo
        $actions_on_user = $request->actions_on_user;
        $file = $request->file('file');
        $type = $request->type;

        if ($file->isValid()) {
            //Obtener el encabezado de Excel
            $headings = (new HeadingRowImport)->toArray($file);

            //si tiene columnas repetidas
            if (!empty(array_diff_assoc($headings[0][0], array_unique($headings[0][0])))) {
                array_push($this->validator_fails, __('The loaded excel has columns with the same header name'));
                return;
            }

            //Si encabezado del titulo trae menos de cinco elementos
            
            if (count(array_filter($headings[0][0])) === 5) {
                array_push($this->validator_fails, __('The Excel file loaded must have more than five column.'));
                return;
            }

            //Si encabezado del titulo es vacio
            if (count(array_filter($headings[0][0])) === 0) {
                array_push($this->validator_fails, __('The loaded Excel is empty or has empty titles.'));
                return;
            }

            // Determinar no trae ni titulo ni sku
            if (!in_array("nombres", $headings[0][0]) &&
                !in_array("apellidos", $headings[0][0]) && 
                !in_array("cedula", $headings[0][0]) && 
                !in_array("telefono", $headings[0][0]) && 
                !in_array("correo", $headings[0][0])) {
                array_push($this->validator_fails, __('The loaded Excel does not have name, last name, id, phone or email column.'));
                return;
            }
        }
    }

    public function verifyEmptyColumn(){
        if(!empty($query['role'])){
            if(!empty("nombres") && !empty("apellidos") && !empty("cedula") && !empty("telefono") && !empty("correo")){
                if($query['role']=="egresado"){
                    if(!empty("modo_registro") && !empty("correo_personal") && !empty("periodo_egreso") && !empty("notificacion") && !empty("carrera")){
                        return true;
                    }
                    return false;
                }
                return true;
            }
        }
        return false;
    }

    //acciones sobre usuarios
    public function actionsOnUser($query)
    {
        $user = null;
        if (!empty($query['cedula']) && !empty($query['correo'])) {
            $user = User::where('cedula', $query['cedula'])->orWhere(where('correo', $query['correo']))->first();
            if (empty($user) && !verifyEmptyColumn()) {
                $this->user_empty_lines .= $this->line . ', ';
                return;
            }
        }

        switch ($this->actions_on_user) {
            //crear y actualizar usuarios
            case 'update_and_create_new_user':
                if (!empty($user)) {
                    $this->updateUser($query, $user);
                } else {
                    $this->createUser($query);
                }
                break;
            //solo actualizar usuarios
            case 'update_existing_user_only':
                if (!empty($user)) {
                    $this->updateUser($query, $user);
                }
                break;
            //solo crear usuarios
            case 'only_create_new_user':
                if (empty($user)) {
                    $this->createUser($query);
                }
                break;
            default:
                break;
        }
    }

    public function errors($err = null)
    {
        if (!empty($err)) {
            $this->errors += $err;

        }
        if (!empty($this->user_empty_lines)) {
            $this->errors += [trans('user_empty_lines', ['row' => $this->user_empty_lines])];
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

    //validar Datos a importar
    public function validator($row, $action = 'create')
    {
        $rules = null;
        request()->request->add($row);      
        if ($action == 'create') {
           
        }
        if ($action == 'update') {
            
        }        
        $validator = Validator::make($row, $rules);
        if ($validator->fails()) {
            $message = $validator->errors();
            $err = trans('error_in', ['row' => $this->line]);
            foreach ($message->messages() as $key => $value) {
                $err .= implode(",", ($value));
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
            
        }
    }

    //actualizar usuarios
    public function updateUser($query, $user)
    {
        $query['id'] = $user->id;      
        if ($this->validator($query, 'update')) {
            $user->update($query);
            $user->productGroups()->sync($user_groups);
        }
    }
}
