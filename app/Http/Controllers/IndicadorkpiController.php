<?php

namespace App\Http\Controllers;

use App\Models\Indicadorkpi;
use Illuminate\Http\Request;
use App\Models\Diariokpi;

use Illuminate\Support\Facades\View;

/**
 * Class IndicadorkpiController
 * @package App\Http\Controllers
 */
class IndicadorkpiController extends Controller
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
    public function index(Request $request )
    {
        $lnombre = $request->get('nombre');    
        $indicadorkpis = Indicadorkpi::indicador($lnombre)
                        ->paginate();
        
        return view('indicadorkpi.index', compact('indicadorkpis'))
            ->with('i', (request()->input('page', 1) - 1) * $indicadorkpis->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $indicadorkpis = Indicadorkpi::paginate();
        $indicadorkpi = new Indicadorkpi();
        return view('indicadorkpi.create', compact('indicadorkpi','indicadorkpis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Indicadorkpi::$rules);

        $indicadorkpi = Indicadorkpi::create($request->all());

        return redirect()->route('indicadorkpis.index')
            ->with('success', 'Indicadorkpi created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $indicadorkpi = Indicadorkpi::find($id);

        return view('indicadorkpi.show', compact('indicadorkpi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ikpis = Indicadorkpi::paginate();
        $indicadorkpi = Indicadorkpi::find($id);
        $indicadorkpis = Indicadorkpi::paginate();

        return view('indicadorkpi.edit', compact('indicadorkpi','indicadorkpis') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Indicadorkpi $indicadorkpi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Indicadorkpi $indicadorkpi)
    {
        request()->validate(Indicadorkpi::$rules);

        $indicadorkpi->update($request->all());

        return redirect()->route('indicadorkpis.index')
            ->with('success', 'Indicadorkpi updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $indicadorkpi = Indicadorkpi::find($id)->delete();

        return redirect()->route('indicadorkpis.index')
            ->with('success', 'Indicadorkpi deleted successfully');
    }
}
