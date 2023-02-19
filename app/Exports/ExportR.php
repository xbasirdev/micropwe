<?php

namespace App\Exports;

use App\Cuestionario;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Carbon\Carbon;

class ExportR implements FromCollection, WithMapping, WithCustomCsvSettings, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;

    protected $cuestionario;

    public function __construct($cuestionario)
    {
        $this->cuestionario = $cuestionario;
    }

    public function headings(): array
    {
        $return  = [
            'Nombre del cuestionario',
            'Pregunta del cuestionario',
            'Respuesta del cuestionario',
            'Nombre del egresado',
            "Cedula del egresado",
            'Carrera del egresado',
            'Fecha de completacion del cuestionario',
            'Codigo de validacion del cuestionario'
        ];
       
       
        return $return;
    }

    public function map($cuestionario_respuesta): array
    {       
        
        return [
            $cuestionario_respuesta->pregunta->cuestionario->nombre,
            $cuestionario_respuesta->pregunta->pregunta,
            $cuestionario_respuesta->respuesta,
            $cuestionario_respuesta->egresado->nombres. " ".$cuestionario_respuesta->egresado->apellidos ,
            $cuestionario_respuesta->egresado->cedula,
            $cuestionario_respuesta->egresado->egresado->carrera->nombre,
            $cuestionario_respuesta->created_at,
            $cuestionario_respuesta->codigoVerificacion->codigo ?? "",
        ];
    }
    public function columnFormats(): array
    {
        $return = [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
        ];
       
        return $return;
    }
    

    public function collection()
    {
        /**
         * @return \Illuminate\Support\Collection
         */

        return $this->cuestionario;
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
