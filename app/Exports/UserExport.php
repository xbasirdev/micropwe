<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class UserExport implements FromCollection, WithMapping, WithCustomCsvSettings, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;

    protected $users;
    protected $type;

    public function __construct($users, $type)
    {
        $this->users = $users;
        $this->type = $type;
    }

    public function headings(): array
    {
        $return  = [
            'Nombres',
            'Apellidos',
            'Cedula',
            'Telefono',
            "Correo",
        ];
       
        if($this->type=='graduate'){
            $return  += [                
                "Correo personal",
                "Periodo de egreso",
                "Fecha de egreso",
                "Carrera ",
                "Notificaciones activas",
                "Modo en el que se registro",
            ]; 
        }
        return $return;
    }

    public function map($user): array
    {
        $return = [
            $user->nombres,
            $user->apellidos,
            $user->cedula,
            $user->telefono,
            $user->correo,
        ];
        if($this->type=='graduate' && !empty($user->egresado)){
            $return  += [     
                $user->egresado->correo,
                $user->egresado->periodo_egreso,
                $user->egresado->fecha_egreso,
                $user->egresado->carrera->nombre,
                $user->egresado->notificacion == 1 ? "Si" : "No",
                $user->egresado->modo_registro,
            ];
        }
        return $return;

    }
    public function columnFormats(): array
    {
        $return = [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
        ];
        if($this->type=='graduate'){
            $return  += [  
                'F' => NumberFormat::FORMAT_TEXT,
                'G' => NumberFormat::FORMAT_TEXT,
                'H' => NumberFormat::FORMAT_TEXT,
                'I' => NumberFormat::FORMAT_TEXT,
                'J' => NumberFormat::FORMAT_TEXT,
                'K' => NumberFormat::FORMAT_TEXT,
            ];
        }
        return $return;
    }
    

    public function collection()
    {
        /**
         * @return \Illuminate\Support\Collection
         */

        return $this->users ?$this->users: User::all();
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
            'use_bom' => false,
            'output_encoding' => 'ISO-8859-1',
        ];
    }
}
