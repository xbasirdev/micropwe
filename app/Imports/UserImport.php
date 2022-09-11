<?php

namespace App\Imports;

use App\User;

use Databyte\CreaWebAdmin\Models\Menu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
class UserImport implements ToCollection, WithHeadingRow, WithCustomCsvSettings
{
    protected $type;
    public $sheetNames;
    public $sheetData;

    public function __construct($user, $type = null)
    {
        $this->type = $type;
        $this->user = $user;
    }

    public function model(array $row)
    {

    }
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1',
            'delimiter' => ';',
        ];
    }
    public function collection(Collection $rows)
    {
        $header = [
            'nombres'=>"Nombres",
            'apellidos'=>"Apellidos",
            'cedula'=>"Cedula",
            'telefono'=>"Telefono",
            "correo"=>"Correo",
            "cambiar_rol"=>"Cambiar Rol"
        ];

        if($this->type=='graduate'){     
            $header +=[        
                "correo_personal" => "Correo personal",
                "periodo_de_egreso" => "Periodo de egreso",
                "fecha_de_egreso" => "Fecha de egreso",
                "carrera" => "Carrera",
                "notificaciones_activas" => "Notificaciones activas",
                "modo_en_el_que_se_registro" => "Modo en el que se registro"
            ];
        }
       
        $row_user_unique = [];
        $row_users = [];
        $cedula_lines = [];

        foreach ($rows as $index => $row) {
            $query_user = [];
            if (!empty($row['nombres'])) {
                $nombres = strtolower(trim($row['nombres']));
                $query_user += ['nombres' => $nombres];
            }

            if (!empty($row['apellidos'])) {
                $apellidos = strtolower(trim($row['apellidos']));
                $query_user += ['apellidos' => $apellidos];
            }

            if (!empty($row['cedula'])) {
                $cedula = $row['cedula'];
                $query_user += ['cedula' => $cedula];
                $cedula_lines += [$row['cedula'] => null];
                array_push($row_user_unique, $cedula);
            }

            if (!empty($row['telefono'])) {
                $telefono = strtolower(trim($row['telefono']));
                $query_user += ['telefono' => $telefono];
            }

            if (!empty($row['correo'])) {
                $correo = strtolower(trim($row['correo']));
                $query_user += ['correo' => $correo];
            }

            if($this->type=='graduate'){ 
               
                if (!empty($row['correo_personal'])) {
                    $correo_personal = strtolower(trim($row['correo_personal']));
                    $query_user += ['correo_personal' => $correo_personal];
                }

                if (!empty($row['periodo_de_egreso'])) {
                    $periodo_de_egreso = strtolower(trim($row['periodo_de_egreso']));
                    $query_user += ['periodo_de_egreso' => $periodo_de_egreso];
                }

                if (!empty($row['fecha_de_egreso'])) {
                    $fecha_de_egreso = strtolower(trim($row['fecha_de_egreso']));
                    $query_user += ['fecha_de_egreso' => $fecha_de_egreso];
                }

                if (!empty($row['carrera'])) {
                    $carrera = strtolower(trim($row['carrera']));
                    $query_user += ['carrera' => $carrera];
                }

                if (!empty($row['modo_en_el_que_se_registro'])) {
                    $modo_en_el_que_se_registro = strtolower(trim($row['modo_en_el_que_se_registro']));
                    $query_user += ['modo_en_el_que_se_registro' => $modo_en_el_que_se_registro];
                }

                if (!empty($row['notificaciones_activas'])) {
                    $notificaciones_activas = strtolower($row['notificaciones_activas']) == strtolower("Si") ? 1 : 0;
                    $query_user += ['notificaciones_activas' => $notificaciones_activas];
                }

                if (!empty($row['cambiar_rol'])) {
                    $cambiar_rol = strtolower($row['cambiar_rol']) == strtolower("Si") ? true : false;
                    $query_user += ['cambiar_rol' => $cambiar_rol];
                }

            }           
            array_push($row_users, $query_user);
        }
        
        $diff_arr = array_diff_assoc($row_user_unique, array_unique($row_user_unique));
        
        foreach ($row_users as $index => $row) {
            if (!empty($row['cedula']) && !empty($diff_arr) && in_array($row['cedula'], $diff_arr)) {
                $cedula_lines[$row['cedula']] .= ($index + 2) . ", ";
            } else {
                $this->user->actionsOnUser($row, $index + 2);
            }
        }

        if (!empty($cedula_lines)) {
            foreach ($cedula_lines as $key => $value) {
                if (!empty($value)) {
                    $this->user->errors("El usuario con celula: ${key} esta duplicado en las lineas: {$value}");
                }
            }
        }
        return $this;
    }
}
