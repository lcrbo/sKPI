<?php

namespace App\Http\Controllers;

use App\Models\Historicokpi;
use App\Models\Indicadorkpi;
use App\Models\Diariokpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use App\Exports\HistoricokpisExport;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
/**
 * Class HistoricokpiController
 * @package App\Http\Controllers
 */
class HistoricokpiController extends Controller
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
    public function index(Request $request,$id)
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
                    
        $maxfechahist = DB::table('historicokpis')
                        ->where('indicadorkpi_id','=',$id) 
                        ->max('fecha')
                        ;   
                    
        $historicokpis = Historicokpi::selectRaw('formato, local, indicadorkpi_id, ROUND(AVG(valor)) valor')
                    ->formato($lformato)
                    ->where('indicadorkpi_id','=', $id)
                    ->where('fecha','=',$maxfechahist)
                    ->Umbral($lumbralCritico,$kpi->umbral2, $lumbralMedio, $lumbralBajo)
                    ->Local($local)
                    ->groupby('indicadorkpi_id')
                    ->groupby('formato')
                    ->groupby('local')
                    ->orderby('valor','asc')
                    ->orderby('fecha','desc')
                    ->orderby('local','asc')
                    ->paginate()
                
                    ; 

        
        return view('historicokpi.index', compact('historicokpis', 'kpi','lformato'),compact('ultimoFecha','ultimoHora'))
              ->with('i', (request()->input('page', 1) - 1) * $historicokpis->perPage())  
            ;






    }


    public function modal(Request $request, $id, $formato, $local)
    {
           
        $lstartDate = $request->get('startDate');
        $lendDate = $request->get('endDate');

        
        
        $kpi = Indicadorkpi::find($id);
        $fechaInicioH =  date('Y-m-d', strtotime( ' - '.$kpi->diasmax.' days'));

        $ultimoFecha = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->max('fecha');
        $ultimoHora = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('fecha','=', $ultimoFecha)
                    ->max('hora')
                    ;

        $locales = Historicokpi::selectRaw('id, formato, local, valor, fecha, indicadorkpi_id')
                    ->where('formato','=', $formato)
                    ->where('local','=', $local)
                    ->where('indicadorkpi_id','=', $id)
                    ->RangoFecha($lstartDate,$lendDate)
                    ->where('fecha','>=', $fechaInicioH)
                    ->orderby('fecha','asc')
                    ->paginate();

       
        
                   /* diario  */
                  
                      $fechasD = Historicokpi::selectRaw('fecha')  
                                ->where('indicadorkpi_id','=',$id) 
                                ->where('formato','=',$formato) 
                                ->where('local','=', $local)
                                ->RangoFecha($lstartDate,$lendDate)
                                ->where('fecha','>=', $fechaInicioH)
                                ->groupby('fecha')
                                ->pluck('fecha') ;
                   
                
               
                    $alvD = Historicokpi::selectRaw('ROUND(AVG(valor),2) alv')
                                ->where('indicadorkpi_id','=',$id) 
                                ->where('formato','=',$formato) 
                                ->where('local','=', $local)
                                ->RangoFecha($lstartDate,$lendDate)
                                ->where('fecha','>=', $fechaInicioH)
                                ->groupby('fecha')
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


        return view('historicokpi.localmodal', compact('locales','kpi',
                    'fechasD','alvD', 'color'
            ) ,compact( 'ultimoFecha','ultimoHora','formato', 'local'))
            ->with('i', (request()->input('page', 1) - 1) * $locales->perPage())
            ;
    }


    public function exportExcel($id, $formato, $local, $archivoExcel) 
    {
        
        return Excel::download(new HistoricokpisExport($id, $formato, $local), $archivoExcel . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $historicokpi = new Historicokpi();
        return view('historicokpi.create', compact('historicokpi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Historicokpi::$rules);

        $historicokpi = Historicokpi::create($request->all());

        return redirect()->route('historicokpis.index')
            ->with('success', 'Historicokpi created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $historicokpi = Historicokpi::find($id);

        return view('historicokpi.show', compact('historicokpi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $historicokpi = Historicokpi::find($id);

        return view('historicokpi.edit', compact('historicokpi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Historicokpi $historicokpi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historicokpi $historicokpi)
    {
        request()->validate(Historicokpi::$rules);

        $historicokpi->update($request->all());

        return redirect()->route('historicokpis.index')
            ->with('success', 'Historicokpi updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $historicokpi = Historicokpi::find($id)->delete();

        return redirect()->route('historicokpis.index')
            ->with('success', 'Historicokpi deleted successfully');
    }
}
