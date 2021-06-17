<?php

namespace App\Exports;


use App\Models\Historicokpi;
use App\Models\Indicadorkpi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class HistoricokpisExport implements FromCollection, WithHeadings, WithMapping
{

    protected $id;
    protected $formato;
    protected $local;

    function __construct($id, $formato, $local) {
            $this->id = $id;
            $this->formato = $formato;
            $this->local = $local;
            
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $kpi = Indicadorkpi::find($this->id);
        $fechaInicioH =  date('Y-m-d', strtotime( ' - '.$kpi->diasmax.' days'));

        $locales = Historicokpi::selectRaw('id, formato, local, valor, DATE_FORMAT(fecha, "%d-%m-%Y") fecha, indicadorkpi_id')
                    ->where('formato','=', $this->formato)
                    ->where('local','=', $this->local)
                    ->where('indicadorkpi_id','=',$this->id)
                    ->where('fecha','>=', $fechaInicioH)
                    ->orderby('fecha','asc')

                    ->get();

        return $locales;
    }

    public function headings(): array
    {
        return [

            'FECHA',
            'VALOR ',

        ];
    }

    public function map($transaction): array
    {
        return [

            $transaction->fecha,
            '' . $transaction->valor,

        ]; 
    }
}
