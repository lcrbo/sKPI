<?php

namespace App\Http\Controllers;

use App\Models\Diariokpi;
use App\Models\Indicadorkpi;
use Illuminate\Http\Request;

use App\Exports\DiariokpisExport;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


    

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class DiariokpiController
 * @package App\Http\Controllers
 */
class DiariokpiController extends Controller
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
        /* $user = Auth::user(); */
        $visibleALV = 0;
        $visibleM10 = 0;
        $visibleOKM = 0;
        $visibleUNI = 0;
        /* if (($user->formato == 'ALL') || ($user->formato == null)){
            $visibleALV = 1;
            $visibleM10 = 1;
            $visibleOKM = 1;
            $visibleUNI = 1; 
        }
        if ($user->formato == 'ALV') {
            $visibleALV = 1;
        }
        if ($user->formato == 'M10') {
            $visibleM10 = 1;
        }

        if ($user->formato == 'OKM') {
            $visibleOKM = 1;
        }
        if ($user->formato == 'UNI') {
            $visibleUNI = 1;
        } */
        View::share('visibleALV', $visibleALV);
        View::share('visibleM10', $visibleM10);
        View::share('visibleOKM', $visibleOKM);
        View::share('visibleUNI', $visibleUNI);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id, $formato)
    {

        $lformato = $request->get('formato');
        $lumbralCritico = $request->get('umbralCritico');
        $lumbralMedio = $request->get('umbralMedio');
        $lumbralBajo = $request->get('umbralBajo');
        $local = $request->get('local');
        
       /*  $indicadorkpis = Indicadorkpi::paginate(); */
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

        $diariokpis = diariokpi::selectRaw('formato, local, indicadorkpi_id, ROUND(AVG(valor)) valor')
                    ->formato($formato)
                    ->where('indicadorkpi_id','=', $id)
                    ->where('fecha','=', $ultimoFecha )
                    ->where('hora','=', $ultimoHora )
                   /*  ->Umbral($lumbralCritico,$kpi->umbral2, $lumbralMedio, $lumbralBajo) */
                    ->Local($local)
                    ->groupby('indicadorkpi_id')
                    ->groupby('formato')
                    ->groupby('local')
                    ->orderby('valor','asc')
                    ->orderby('local','asc')
                    ->paginate();

        /* $wordCount = count($diariokpis); */
        
        $user = Auth::user();
        View::share('user', $user);

/*         return view('diariokpi.index', compact('diariokpis','kpi','lformato') ,compact('indicadorkpis', 'ultimoFecha','ultimoHora'))
             ->with('i', (request()->input('page', 1) - 1) * $diariokpis->perPage()) ; */
             return view('diariokpi.index', compact('diariokpis','kpi','lformato') ,compact( 'ultimoFecha','ultimoHora'))
             ->with('i', (request()->input('page', 1) - 1) * $diariokpis->perPage()) ;
    }

    public function listadiarioall(Request $request,$id)
    {

        $lformato = $request->get('formato');
        $lumbralCritico = $request->get('umbralCritico');
        $lumbralMedio = $request->get('umbralMedio');
        $lumbralBajo = $request->get('umbralBajo');
        $local = $request->get('local');
       
        $kpi = Indicadorkpi::find($id);

        $ultimoFecha = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->max('fecha');
        $ultimoHora = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('fecha','=', $ultimoFecha)
                    ->max('hora')
                    ;

         $diariokpis = diariokpi::selectRaw('formato, local, indicadorkpi_id, AVG(valor) valor')
                    ->formato($lformato) 
                    ->where('indicadorkpi_id','=', $id)
                    ->where('fecha','=', $ultimoFecha )
                   /*  ->Umbral($lumbralCritico,$kpi->umbral2, $lumbralMedio, $lumbralBajo) */
                    ->Local($local)
                    ->groupby('indicadorkpi_id')
                    ->groupby('formato')
                    ->groupby('local')
                    ->orderby('valor','asc')
                    ->orderby('local','asc')
                    ->paginate();

        $user = Auth::user();
        View::share('user', $user);
        
                        
        /*$formato =  $diariokpis::first()->formato; */ 

        return view('diariokpi.listadiarioall', compact('diariokpis','kpi','lformato') ,compact( 'ultimoFecha','ultimoHora'))
             ->with('i', (request()->input('page', 1) - 1) * $diariokpis->perPage()) ;
    }


    public function modal($id, $formato, $local)
    {
           
     
        $kpi = Indicadorkpi::find($id);

        $ultimoFecha = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->max('fecha');
        $ultimoHora = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('fecha','=', $ultimoFecha)
                    ->max('hora')
                    ;

        $locales = diariokpi::selectRaw('id, formato, local, valor,  hora, indicadorkpi_id')
                    ->where('formato','=', $formato)
                    ->where('local','=', $local)
                    ->where('indicadorkpi_id','=', $id)
                    ->where('fecha','=', $ultimoFecha )
                    ->orderby('hora','asc')
                    ->paginate();

                 
        
        /* diario  */
      
         $fechasD = diariokpi::selectRaw(' hora')  
                    ->where('formato','=', $formato)
                    ->where('local','=', $local)
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('fecha','=',$ultimoFecha)
                    ->groupby('hora')
                    ->pluck('hora') ;
        
    
    
        $alvD = diariokpi::selectRaw('AVG(valor) alv')
                    ->where('formato','=', $formato)
                    ->where('local','=', $local)
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('fecha','=',$ultimoFecha)
                    ->groupby('hora')
                    ->pluck('alv') ;
    
                   
        $user = Auth::user();
        View::share('user', $user);    
            
            
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

        return view('diariokpi.localmodal', compact('locales','kpi',
                    'fechasD','alvD', 'color'
            ) ,compact( 'ultimoFecha','ultimoHora'))
            ->with('i', (request()->input('page', 1) - 1) * $locales->perPage())
            ;
    }



    public function exportExcel($id, $formato, $local, $archivoExcel) 
    {
        //return Excel::download(new DiariokpisExport, 'Diariokpis.'.$type);
        return Excel::download(new DiariokpisExport($id, $formato, $local), $archivoExcel . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $diariokpi = new Diariokpi();
        return view('diariokpi.create', compact('diariokpi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Diariokpi::$rules);

        $diariokpi = Diariokpi::create($request->all());

        return redirect()->route('diariokpis.index')
            ->with('success', 'Diariokpi created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $diariokpi = Diariokpi::find($id);

        return view('diariokpi.show', compact('diariokpi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $diariokpi = Diariokpi::find($id);

        return view('diariokpi.edit', compact('diariokpi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Diariokpi $diariokpi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diariokpi $diariokpi)
    {
        request()->validate(Diariokpi::$rules);

        $diariokpi->update($request->all());

        return redirect()->route('diariokpis.index')
            ->with('success', 'Diariokpi updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $diariokpi = Diariokpi::find($id)->delete();

        return redirect()->route('diariokpis.index')
            ->with('success', 'Diariokpi deleted successfully');
    }
}
