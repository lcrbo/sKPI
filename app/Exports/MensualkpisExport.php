<?php

namespace App\Exports;


use App\Models\Mensualkpi;
use App\Models\Indicadorkpi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class MensualkpisExport implements FromCollection, WithHeadings, WithMapping
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

        $kpi = Indicadorkpi::find( $this->id);
        $fechaInicioM =  date('Y-m-01', strtotime( ' - '.$kpi->mesesmax.' months'));

        $locales = mensualkpi::selectRaw('id, formato, local, valor, DATE_FORMAT(mes, "%m-%Y") mes, indicadorkpi_id')
                    ->where('formato','=', $this->formato)
                    ->where('local','=', $this->local)
                    ->where('indicadorkpi_id','=', $this->id)
                    ->where('mes','>=', $fechaInicioM)
                    ->orderby('mes', 'asc')
                    ->get();

        return $locales;
        
    }

    public function headings(): array
    {
        return [

            'MES',
            'VALOR',

        ];
    }

    public function map($transaction): array
    {
        return [

            $transaction->mes,
            '' . $transaction->valor,

        ];
    }
}
