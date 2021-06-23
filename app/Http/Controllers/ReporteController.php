<?php

namespace App\Http\Controllers;
use App\Models\Indicadorkpi;
use App\Models\Historicokpi;
use App\Models\Diariokpi;
use App\Models\Mensualkpi;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use PDF;


class ReporteController extends Controller
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
                        ->where('indicadorkpi_id','=',$kpi->id) 
                        ->where('formato','=','ALV') 
                        ->groupby('local')
                        ->get() ;

        
        View::share('locales', $locales);
        
        
        $visibleALV = 0;
        $visibleM10 = 0;
        $visibleOKM = 0;
        $visibleUNI = 0;
       /*  $user = Auth::user();
        if (($user->formato == 'ALL') || ($user->formato == null)){
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


    public function localesbyid($id,$formato)
    {
        $user = Auth::user();
        View::share('user', $user);

        $locales = diariokpi::selectRaw('local')
                        ->where('indicadorkpi_id','=',$id) 
                        ->where('formato','=',$formato) 
                        ->groupby('local')
                        ->get() ;
        /* return Response::json($locales); */
        dd($locales);
        return $locales;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $id = $request->get('idkpi');
        $lformato = $request->get('formato');
        $llocal = $request->get('local');

        $lstartDateH = $request->get('startDateH');
        $lendDateH = $request->get('endDateH');
        $lstartDateM = $request->get('startDateM');
        $lendDateM = $request->get('endDateM');
       
       
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

         $diariokpis = diariokpi::selectRaw('ROUND(AVG(valor)) average, formato')
                                ->where('indicadorkpi_id','=',$id) 
                                ->where('formato','=',$lformato) 
                                ->where('local','=',$llocal) 
                                ->where('fecha','=', $ultimoFecha)
                                ->where('hora','=',$ultimoHora)  
                                ->groupby('formato')
                                ->get() ; 
         
                           
        $hoykpis = diariokpi::selectRaw('hora, ROUND(AVG(valor)) valor')
                                ->where('indicadorkpi_id','=',$id) 
                                ->where('formato','=',$lformato) 
                                ->where('local','=',$llocal) 
                                ->where('fecha','=',$ultimoFecha)
                                ->groupby('fecha')
                                ->groupby('hora')
                                ->get()  ;
                           
        
        
   
/* historico */

       $fechasH = historicokpi::selectRaw(' fecha')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal) 
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('fecha') ;
            
        $alvH = historicokpi::selectRaw('ROUND(AVG(valor)) alv')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal)  
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('alv') ;

              

/* MENSUAL */
        $fechasM = mensualkpi::selectRaw(' mes')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal)  
                ->where('mes','>=', $fechaInicioM)
                ->RangoFecha($lstartDateM,$lendDateM)
                ->groupby('mes')
                ->pluck('mes') ;

        $alvM = mensualkpi::selectRaw('ROUND(AVG(valor)) alv')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal) 
                ->where('mes','>=', $fechaInicioM)
                ->RangoFecha($lstartDateM,$lendDateM)
                ->groupby('mes')
                ->pluck('alv') ;

       
                    
/* diario  */

        $fechasD = diariokpi::selectRaw(' hora')
                        ->where('indicadorkpi_id','=',$id) 
                        ->where('formato','=',$lformato) 
                        ->where('local','=',$llocal) 
                        ->where('fecha','=',$ultimoFecha)
                        ->groupby('fecha')
                        ->groupby('hora')
                        ->pluck('hora') ;
                    
        $alvD = diariokpi::selectRaw('ROUND(AVG(valor)) alv')
                        ->where('indicadorkpi_id','=',$id) 
                        ->where('formato','=',$lformato) 
                        ->where('local','=',$llocal) 
                        ->where('fecha','=',$ultimoFecha)
                        ->groupby('fecha')
                        ->groupby('hora')
                        ->pluck('alv') ;

       


        $alvaverage = $diariokpis->average;
        

        $colorALV = 'blue';
        $colorM10 = '#FF7733';
        $colorOKM = '#6C147F';
        $colorUNI = 'red';
        
        if ($lformato=='ALV')
                $color = $colorALV;
        if ($lformato=='M10')
                $color = $colorM10;
        if ($lformato=='OKM')
                $color = $colorOKM;
        if ($lformato=='UNI')
                $color = $colorUNI;
   
        $data = [
                'kpi' => $kpi,
                'fechasD' => $fechasD,
                'alvD' => $alvD,
                'fechasH' => $fechasH,
                'alvH'=> $alvH,
                'fechasM'=> $fechasM,
                'alvM'=> $alvM,
                'color'=> $color,
                'alvaverage'=> $alvaverage,
                'lformato'=> $lformato, 
                'llocal'=> $llocal,
                'diariokpis'=> $diariokpis,
                'ultimoFecha' => $ultimoFecha,
                'ultimoHora' => $ultimoHora
                ];
        View::share('diariokpis', $diariokpis);
        View::share('fechasD' , $fechasD);
        View::share('alvD' , $alvD);
        View::share('fechasH' , $fechasH);
        View::share('alvH', $alvH);
        View::share('fechasM', $fechasM);
        View::share('alvM', $alvM);
        View::share('color', $color);
        View::share( 'alvaverage', $alvaverage);
        View::share('lformato', $lformato);
        View::share('llocal', $llocal);
        View::share( 'diariokpis', $diariokpis);
        View::share('ultimoFecha' , $ultimoFecha);
        View::share('ultimoHora', $ultimoHora);

        /* $pdf = PDF::loadView('reportes.prueba', $data);

        return $pdf->download('reportelocal.pdf'); 
 */

        $user = Auth::user();
        View::share('user', $user);

         return view('reportes.index', 
                compact('kpi',
                'fechasD','alvD',
                'fechasH','alvH',
                'fechasM','alvM',
                'color',
                'alvaverage',
                'lformato', 'llocal'), 
                compact('diariokpis','ultimoFecha','ultimoHora', 'hoykpis'))
                    
           ; 

    }


    public function local(Request $request, $id, $formato, $local)
    {
        
        $lformato = $formato;
        $llocal =  $local;

        $lstartDateH = $request->get('startDateH');
        $lendDateH = $request->get('endDateH');
        $lstartDateM = $request->get('startDateM');
        $lendDateM = $request->get('endDateM');
       
       
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

        $diariokpis = diariokpi::selectRaw('ROUND(AVG(valor)) average, formato')
                                ->where('indicadorkpi_id','=',$id) 
                                ->where('formato','=',$lformato) 
                                ->where('local','=',$llocal) 
                                ->where('fecha','=', $ultimoFecha)
                                ->where('hora','=',$ultimoHora)  
                                ->groupby('formato')
                                ->get() ;
                
        $hoykpis = diariokpi::selectRaw('hora, ROUND(AVG(valor)) valor')
                                ->where('indicadorkpi_id','=',$id) 
                                ->where('formato','=',$lformato) 
                                ->where('local','=',$llocal) 
                                ->where('fecha','=',$ultimoFecha)
                                ->groupby('fecha')
                                ->groupby('hora')
                                ->get()  ;                  
         
        
   
/* historico */

       $fechasH = historicokpi::selectRaw(' fecha')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal) 
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('fecha') ;
            
        $alvH = historicokpi::selectRaw('ROUND(AVG(valor)) alv')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal)  
                ->where('fecha','>=', $fechaInicioH)
                ->RangoFecha($lstartDateH,$lendDateH)
                ->groupby('fecha')
                ->pluck('alv') ;

              

/* MENSUAL */
        $fechasM = mensualkpi::selectRaw(' mes')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal)  
                ->where('mes','>=', $fechaInicioM)
                ->RangoFecha($lstartDateM,$lendDateM)
                ->groupby('mes')
                ->pluck('mes') ;

        $alvM = mensualkpi::selectRaw('ROUND(AVG(valor)) alv')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal) 
                ->where('mes','>=', $fechaInicioM)
                ->RangoFecha($lstartDateM,$lendDateM)
                ->groupby('mes')
                ->pluck('alv') ;

       
                    
/* diario  */

        $fechasD = diariokpi::selectRaw(' hora')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal) 
                ->where('fecha','=',$ultimoFecha)
                ->groupby('fecha')
                ->groupby('hora')
                ->pluck('hora') ;
                    
        $alvD = diariokpi::selectRaw('ROUND(AVG(valor)) alv')
                ->where('indicadorkpi_id','=',$id) 
                ->where('formato','=',$lformato) 
                ->where('local','=',$llocal) 
                ->where('fecha','=',$ultimoFecha)
                ->groupby('fecha')
                ->groupby('hora')
                ->pluck('alv') ;

       


        $alvaverage = $diariokpis->average;
        

        $colorALV = 'blue';
        $colorM10 = '#FF7733';
        $colorOKM = '#6C147F';
        $colorUNI = 'red';
        
        if ($lformato=='ALV')
                $color = $colorALV;
        if ($lformato=='M10')
                $color = $colorM10;
        if ($lformato=='OKM')
                $color = $colorOKM;
        if ($lformato=='UNI')
                $color = $colorUNI;
   
        $user = Auth::user();
        View::share('user', $user);      
       

         return view('reportes.index', 
                compact('kpi',
                'fechasD','alvD',
                'fechasH','alvH',
                'fechasM','alvM',
                'color',
                'alvaverage',
                'lformato', 'llocal'), 
                compact('diariokpis','ultimoFecha','ultimoHora','hoykpis'))
                    
           ; 

    }



}