<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportD implements FromArray,  WithCustomCsvSettings, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $cuestionario;
    protected $datos;

    public function __construct($cuestionario, $datos)
    {
        $this->cuestionario = $cuestionario;
        $this->datos = $datos;

    }

    public function headings(): array
    {
        $return = [
            'Nombre del cuestionario',
            'Numero de preguntas del cuestionario',
            'Total de veces completado el cuestionario',
            'Total de veces completado el cuestionario en el mes de ' . Carbon::now()->format("MM"),
            'Total de veces completado el cuestionario hoy ' . Carbon::now()->format("d-m-yy"),
        ];

        return $return;
    }

    function array(): array
    {
        return [
            [$this->cuestionario->nombre ?? "",
            $this->cuestionario->preguntas()->count() > 0 ? $this->cuestionario->preguntas()->count() : 0,
            $this->datos["total"] ?? 0,
            $this->datos["total_dia"] ?? 0,
            $this->datos["total_mes"]?? 0],
        ];
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
