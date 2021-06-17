<?php

namespace App\Exports;

use App\Models\Diariokpi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;



class DiariokpisExport implements FromCollection, WithHeadings, WithMapping
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
        $ultimoFecha = diariokpi::where('indicadorkpi_id','=',$this->id) 
                    ->max('fecha');

        $locales = diariokpi::selectRaw('id, formato, local, valor, substring(hora,1,5) hora, indicadorkpi_id')
                    ->where('formato','=', $this->formato)
                    ->where('local','=', $this->local)
                    ->where('indicadorkpi_id','=',$this->id )
                    ->where('fecha','=', $ultimoFecha )
                    
                    ->orderby('hora','asc')
                    
                    ->get();
        return $locales;
    }

    public function headings(): array
    {
        return [

            'Hora',
            'valor',

        ];
    }


    public function map($transaction): array
    {
        return [

            $transaction->hora,
            '' . $transaction->valor ,

        ];
    }
}
