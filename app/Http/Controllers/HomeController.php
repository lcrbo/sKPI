<?php

namespace App\Http\Controllers;
use App\Models\Indicadorkpi;
use App\Models\Historicokpi;
use App\Models\Diariokpi;
use App\Models\Mensualkpi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

       

            $visibleALV = 1;
            $visibleM10 = 1;
            $visibleOKM = 1;
            $visibleUNI = 1; 

        View::share('visibleALV', $visibleALV);
        View::share('visibleM10', $visibleM10);
        View::share('visibleOKM', $visibleOKM);
        View::share('visibleUNI', $visibleUNI);

        $user = Auth::user();
        View::share('user', $user);
    }

    
    public function formatoall($id,$formato)
    {
        

        $ultimoFecha = DB::table('diariokpis')
                        ->max('fecha');

        $ultimoHora = DB::table('diariokpis')
                        ->where('fecha','=', $ultimoFecha)
                        ->max('hora')
                        ;

        $diariokpis = diariokpi::selectRaw('indicadorkpi_id id, formato')
                            ->where('fecha','=', $ultimoFecha)
                            ->where('hora','=',$ultimoHora)  
                            ->groupby('indicadorkpi_id')
                            ->groupby('formato')
                            ->get() ;

        foreach( $diariokpis as $index ) {
            $kpi = Indicadorkpi::find($index->id);

            $totallocales = diariokpi::selectRaw('count(*) total')
                        ->where('indicadorkpi_id','=', $index->id)
                        ->where('formato','=',$index->formato)      
                        ->where('fecha','=', $ultimoFecha)
                        ->where('hora','=',$ultimoHora) 
                        ->count() ;
            
            

            $critico = diariokpi::selectRaw('count(*) total')
                        ->where('indicadorkpi_id','=', $index->id)
                        ->where('formato','=',$index->formato)      
                        ->where('fecha','=', $ultimoFecha)
                        ->where('hora','=',$ultimoHora) 
                        ->SoloUmbralCritico($kpi->umbral2)
                        ->count() ;
            $index->critico = round( ( $critico * 100) /$totallocales,1)  ;

            $medio = diariokpi::selectRaw('count(*) total')
                        ->where('indicadorkpi_id','=', $index->id)
                        ->where('formato','=',$index->formato)      
                        ->where('fecha','=', $ultimoFecha)
                        ->where('hora','=',$ultimoHora) 
                        ->UmbralMedio($kpi->umbral2, $kpi->umbral3)
                        ->count() ;
            $index->medio = round(( $medio * 100) /$totallocales ,1) ;

            $bajo = diariokpi::selectRaw('count(*) total')
                        ->where('indicadorkpi_id','=', $index->id)
                        ->where('formato','=',$index->formato)      
                        ->where('fecha','=', $ultimoFecha)
                        ->where('hora','=',$ultimoHora) 
                        ->SoloUmbralBajo( $kpi->umbral3)
                        ->count() ;
            $index->bajo = round(( $bajo * 100) /$totallocales ,1) ;
        }
        return $diariokpis;
    }

    public function formatoDetalle($id,$formato)
    {
        $ultimoFecha = DB::table('diariokpis')
                        ->max('fecha');

        $ultimoHora = DB::table('diariokpis')
                        ->where('fecha','=', $ultimoFecha)
                        ->max('hora')
                        ;
        $totallocales = diariokpi::selectRaw('count(*) total')
                    ->where('indicadorkpi_id','=', $id)
                    ->where('formato','=',$formato)  
                    ->where('fecha','=', $ultimoFecha)
                    ->where('hora','=',$ultimoHora) 
                    ->get() ;

        
        
        return $totallocales;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id = 1)
    {

        if ($id)
            $kpi = Indicadorkpi::find($id);
       
        View::share('kpi', $kpi);


        
        $kpis = Indicadorkpi::all();

        $ultimoFecha = DB::table('diariokpis')
                        ->where('indicadorkpi_id','=',$kpis[0]->id) 
                        ->max('fecha');

        $ultimoHora = DB::table('diariokpis')
                        ->where('indicadorkpi_id','=',$kpis[0]->id) 
                        ->where('fecha','=', $ultimoFecha)
                        ->max('hora')
                        ;

        if ( ($ultimoFecha == null)  && ($ultimoHora == null) ) {

            return view('error', compact( 'kpi'));
        }
        
        foreach( $kpis as $index ) {

            
            $diariokpis = diariokpi::selectRaw('formato')
                            ->where('indicadorkpi_id','=',$index->id) 
                            ->where('fecha','=', $ultimoFecha)
                            ->where('hora','=',$ultimoHora)  
                            ->groupby('formato')
                            ->get() ;
            $index->datosD = $diariokpis;
        }

        $diariokpis = diariokpi::selectRaw('formato')
                            ->where('indicadorkpi_id','=',$id) 
                            ->where('fecha','=', $ultimoFecha)
                            ->where('hora','=',$ultimoHora)  
                            ->groupby('formato')
                            ->get() ;
        
        $user = Auth::user();
        View::share('user', $user);
        
        
        return view('home', compact( 'kpis','ultimoFecha','ultimoHora','diariokpis'))
           ;

    }

   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index2(Request $request, $id)
    {

        $lstartDateH = $request->get('startDateH');
        $lendDateH = $request->get('endDateH');
        $lstartDateM = $request->get('startDateM');
        $lendDateM = $request->get('endDateM');
      /*  dd($request); */
        $kpi = Indicadorkpi::find($id);
        View::share('kpi', $kpi);
        

        $fechaInicioH =  date('Y-m-d', strtotime( ' - '.$kpi->diasmax.' days'));
        $fechaInicioM =  date('Y-m-01', strtotime( ' - '.$kpi->mesesmax.' months'));
       
        
        $ultimoFecha = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->max('fecha');

        $ultimoHora = DB::table('diariokpis')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('fecha','=', $ultimoFecha)
                    ->max('hora')
                    ;

        if ( ($ultimoFecha == null)  && ($ultimoHora == null) ) {
                
            return view('error', compact( 'kpi'));
        }

        $diariokpis = diariokpi::selectRaw('AVG(valor) average, formato')
                            ->where('indicadorkpi_id','=',$id) 
                            ->where('fecha','=', $ultimoFecha)
                            ->where('hora','=',$ultimoHora) 
                            ->groupby('formato')
                            ->get() ;
                
         
                           

   
/* historico */

     
         $fechasH = historicokpi::selectRaw('fecha') 
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=','ALV') 
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('fecha') ;
        
        $alvH = historicokpi::selectRaw('AVG(valor) alv')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=','ALV') 
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('alv') ;

        $uniH = historicokpi::selectRaw('AVG(valor) uni')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=','UNI') 
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('uni') ;
        $m10H = historicokpi::selectRaw('AVG(valor) m10')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=','M10') 
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('m10') ;
        $okmH = historicokpi::selectRaw('AVG(valor) okm')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=','OKM') 
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('okm') ;
        

/* MENSUAL */
       
          $fechasM = mensualkpi::selectRaw(' mes') 
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','ALV') 
                    ->where('mes','>=', $fechaInicioM)
                    ->RangoFecha($lstartDateM,$lendDateM)
                    ->groupby('mes')
                    ->pluck('mes') ;
        
        $alvM = mensualkpi::selectRaw('AVG(valor) alv')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','ALV') 
                    ->where('mes','>=', $fechaInicioM)
                    ->RangoFecha($lstartDateM,$lendDateM)
                    ->groupby('mes')
                    ->pluck('alv') ;

        $uniM = mensualkpi::selectRaw('AVG(valor) uni')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','UNI') 
                    ->where('mes','>=', $fechaInicioM)
                    ->RangoFecha($lstartDateM,$lendDateM)
                    ->groupby('mes')
                    ->pluck('uni') ;
        $m10M = mensualkpi::selectRaw('AVG(valor) m10')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','M10') 
                    ->where('mes','>=', $fechaInicioM)
                    ->RangoFecha($lstartDateM,$lendDateM)
                    ->groupby('mes')
                    ->pluck('m10') ;
        $okmM = mensualkpi::selectRaw('AVG(valor) okm')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','OKM') 
                    ->where('mes','>=', $fechaInicioM)
                    ->RangoFecha($lstartDateM,$lendDateM)
                    ->groupby('mes')
                    ->pluck('okm') ;
                    
/* diario  */
  
        $fechasD = diariokpi::selectRaw('hora') 
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','ALV') 
                    ->where('fecha','=',$ultimoFecha)
                    ->groupby('hora')
                    ->pluck('hora') ;
    
            
        $alvD = diariokpi::selectRaw('AVG(valor) alv')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','ALV') 
                    ->where('fecha','=',$ultimoFecha)
                    ->groupby('hora')
                    ->pluck('alv') ;

        $uniD = diariokpi::selectRaw('AVG(valor) uni')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','UNI') 
                    ->where('fecha','=',$ultimoFecha)
                    ->groupby('hora')
                    ->pluck('uni') ;
        

        $m10D = diariokpi::selectRaw('AVG(valor) m10')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','M10') 
                    ->where('fecha','=',$ultimoFecha)
                    ->groupby('hora')
                    ->pluck('m10') ;
        $okmD = diariokpi::selectRaw('AVG(valor) okm')
                    ->where('indicadorkpi_id','=',$id) 
                    ->where('formato','=','OKM') 
                    ->where('fecha','=',$ultimoFecha)
                    ->groupby('hora')
                    ->pluck('okm') ;


     

        $colorALV = 'blue';
        $colorM10 = '#FF7733';
        $colorOKM = '#6C147F';
        $colorUNI = 'red';
        
       
        $nombreALV = 'AlV';
        $nombreM10 = 'M10';
        $nombreOKM = 'OKM';
        $nombreUNI = 'UNI';


        $user = Auth::user();
        View::share('user', $user);
        
        if (($user->formato == 'ALL') || ($user->formato == null)){
            $visibleALV = 1;
            $visibleM10 = 1;
            $visibleOKM = 1;
            $visibleUNI = 1; 
        }
        if ($user->formato == 'ALV') {
            $visibleALV = 1;
            
            $visibleM10 = 0;
            $m10D = null;
            $m10H = null;
            $m10M = null;
            
            $visibleOKM = 0;
            $okmD = null;
            $okmH = null;
            $okmM = null;
            
            $visibleUNI = 0;
            $uniD= null;
            $uniH = null;
            $uniM = null;
            
        }
        if ($user->formato == 'M10') {
            $visibleALV = 0;
            $alvD = null;
            $alvH = null;
            $alvM = null;
            
            $visibleM10 = 1;

            
            $visibleOKM = 0;
            $okmD = null;
            $okmH = null;
            $okmM = null;
            
            $visibleUNI = 0;
            $uniD= null;
            $uniH = null;
            $uniM = null;
            
        }

        if ($user->formato == 'OKM') {
            $visibleALV = 0;
            $alvD = null;
            $alvH = null;
            $alvM = null;
            
            $visibleM10 = 0;
            $m10D = null;
            $m10H = null;
            $m10M = null;
            
            $visibleOKM = 1;

            
            $visibleUNI = 0;
            $uniD= null;
            $uniH = null;
            $uniM = null;
            
        }
        if ($user->formato == 'UNI') {
            $visibleALV = 0;
            $alvD = null;
            $alvH = null;
            $alvM = null;
            
            $visibleM10 = 0;
            $m10D = null;
            $m10H = null;
            $m10M = null;
            
            $visibleOKM = 0;
            $okmD = null;
            $okmH = null;
            $okmM = null;
            
            $visibleUNI = 1;
          
            
        }

        View::share('visibleALV', $visibleALV);
        View::share('visibleM10', $visibleM10);
        View::share('visibleOKM', $visibleOKM);
        View::share('visibleUNI', $visibleUNI);
        

        return view('home2', 
                compact('kpi',
                'fechasD','alvD','uniD','m10D','okmD',
                'fechasH','alvH','uniH','m10H','okmH',
                'fechasM','alvM','uniM','m10M','okmM',
                'colorALV','colorM10','colorOKM','colorUNI',
                'nombreALV','nombreM10','nombreOKM','nombreUNI',
                'visibleALV','visibleM10','visibleOKM','visibleUNI',
                ), 
                compact('diariokpis','ultimoFecha','ultimoHora'))
                    
           ;

    }



    public function error()
    {
        $indicadorkpis = Indicadorkpi::paginate();
        return view('error', compact('indicadorkpis'    ));
         
    }



}



