<?php

namespace App\Http\Controllers;

use App\Models\Mensualkpi;
use App\Models\Indicadorkpi;
use App\Models\Diariokpi;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use App\Exports\MensualkpisExport;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class MensualkpiController
 * @package App\Http\Controllers
 */
class MensualkpiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $indicadorkpis = Indicadorkpi::all();
        
        View::share('indicadorkpis', $indicadorkpis);
        $kpi = Indicadorkpi::find(1);
        View::share('kpi', $kpi);
        $locales = diariokpi::selectRaw('local')
        ->groupby('local')
         ->get() ;
View::share('locales', $locales);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {

        $lformato = $request->get('formato');
        $lumbralCritico = $request->get('umbralCritico');
        $lumbralMedio = $request->get('umbralMedio');
        $lumbralBajo = $request->get('umbralBajo');
        $local = $request->get('local');

          
            $kpi = Indicadorkpi::find($id);
            
            View::share('kpi', $kpi);
    
            $ultimoFecha = DB::table('diariokpis')
                        ->where('indicadorkpi_id','=',$id) 
                        ->max('fecha');
            $ultimoHora = DB::table('diariokpis')
                        ->where('indicadorkpi_id','=',$id) 
                        ->where('fecha','=', $ultimoFecha)
                        ->max('hora')
                        ;     
                    
            $maxfechames = DB::table('mensualkpis')
                        ->where('indicadorkpi_id','=',$id) 
                        ->max('mes')
                        ;  
            $mensualkpis = Mensualkpi::selectRaw('formato, local, indicadorkpi_id, ROUND(AVG(valor)) valor')
                        ->formato($lformato)
                        ->where('indicadorkpi_id','=', $id)
                        ->where('mes','=',$maxfechames )
                        ->Umbral($lumbralCritico,$kpi->umbral2, $lumbralMedio, $lumbralBajo)
                        ->Local($local)
                        ->groupby('indicadorkpi_id')
                        ->groupby('formato')
                        ->groupby('local')
                        ->orderby('valor','asc')
                        ->orderby('mes','desc')
                        ->orderby('local','asc')
                        ->paginate();
                        ; 

                             
            return view('mensualkpi.index', compact('mensualkpis','kpi','lformato'),compact('ultimoFecha','ultimoHora'))
                ;

    }


    
    public function modal(Request $request,$id, $formato, $local)
    {
           
        $lstartDate = $request->get('startDate');
        $lendDate = $request->get('endDate');

     
        $kpi = Indicadorkpi::find($id);
        $fechaInicioM =  date('Y-m-01', strtotime( ' - '.$kpi->mesesmax.' months'));

        $ultimoFecha = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->max('fecha');
        $ultimoHora = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('fecha','=', $ultimoFecha)
                    ->max('hora')
                    ;

        $locales = mensualkpi::selectRaw('id, formato, local, valor, mes, indicadorkpi_id')
                    ->where('formato','=', $formato)
                    ->where('local','=', $local)
                    ->where('indicadorkpi_id','=', $id)
                    ->RangoFecha($lstartDate,$lendDate)
                    ->where('mes','>=', $fechaInicioM)
                    ->orderby('mes', 'asc')
                    
                    ->paginate();

                 
        
                   /* diario  */
                   
                     $fechasD = mensualkpi::selectRaw("mes") 
                    ->where('indicadorkpi_id','=',$id) 
                                ->where('formato','=',$formato) 
                                ->where('local','=', $local)
                                ->RangoFecha($lstartDate,$lendDate)
                                ->where('mes','>=', $fechaInicioM)
                                ->groupby('mes')
                                ->orderby('mes', 'asc')
                                ->pluck('mes') ;
                   
               
                    $alvD = mensualkpi::selectRaw('ROUND(AVG(valor),2) alv')
                                ->where('indicadorkpi_id','=',$id) 
                                ->where('formato','=',$formato) 
                                ->where('local','=', $local)
                                ->RangoFecha($lstartDate,$lendDate)
                                ->where('mes','>=', $fechaInicioM)
                                ->orderby('mes', 'asc')
                                ->groupby('mes')
                                
                                ->pluck('alv') ;
        
                                $colorALV = 'blue';
        $colorM10 = '#FF7733';
        $colorOKM = '#6C147F';
        $colorUNI = 'red';   
           
        if ($formato=='ALV')
               $color = $colorALV;
        if ($formato=='M10')
               $color = $colorM10;
        if ($formato=='OKM')
               $color = $colorOKM;
        if ($formato=='UNI')
               $color = $colorUNI;


        return view('mensualkpi.localmodal', compact('locales','kpi',
                    'fechasD','alvD', 'color',
                    'formato', 'local'
            ) ,compact('ultimoFecha','ultimoHora'))
            ->with('i', (request()->input('page', 1) - 1) * $locales->perPage())
            ;
    }

    public function exportExcel(Request $request,$id, $formato, $local, $archivoExcel) 
    {
        
        return Excel::download(new MensualkpisExport($id, $formato, $local), $archivoExcel . '.xlsx'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mensualkpi = new Mensualkpi();
        return view('mensualkpi.create', compact('mensualkpi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Mensualkpi::$rules);

        $mensualkpi = Mensualkpi::create($request->all());

        return redirect()->route('mensualkpis.index')
            ->with('success', 'Mensualkpi created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mensualkpi = Mensualkpi::find($id);

        return view('mensualkpi.show', compact('mensualkpi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mensualkpi = Mensualkpi::find($id);

        return view('mensualkpi.edit', compact('mensualkpi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mensualkpi $mensualkpi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensualkpi $mensualkpi)
    {
        request()->validate(Mensualkpi::$rules);

        $mensualkpi->update($request->all());

        return redirect()->route('mensualkpis.index')
            ->with('success', 'Mensualkpi updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $mensualkpi = Mensualkpi::find($id)->delete();

        return redirect()->route('mensualkpis.index')
            ->with('success', 'Mensualkpi deleted successfully');
    }
}
