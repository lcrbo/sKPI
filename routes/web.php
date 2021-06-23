<?php

use App\Http\Controllers\HomeController;

use App\Http\Controllers\HistoricokpiController;
use App\Http\Controllers\IndicadorkpiController;
use App\Http\Controllers\DiariokpiController;
use App\Http\Controllers\MensualkpiController;
use App\Http\Controllers\ReporteController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
})->name('raiz');

Auth::routes();

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    
  
});

Route::middleware(['auth', 'verified'])->get('users.password/{id}', [UserController::class, 'editPassword'])->name('users.password');
Route::middleware(['auth', 'verified'])->patch('users.updatePassword/{id}', [UserController::class, 'updatePassword'])->name('users.updatePassword');


Route::middleware(['auth', 'verified'])->get('users', [UserController::class, 'index'])->name('users.index');
Route::middleware(['auth', 'verified'])->get('roles', [RoleController::class, 'index'])->name('roles.index');


/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/
Route::get('/kpi2', [App\Http\Controllers\HomeController::class, 'index'])->name('kpi2');
Route::middleware(['auth', 'verified'])->get('kpi/{id}', [HomeController::class, 'index2'])->name('kpi');
Route::middleware(['auth', 'verified'])->get('home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'verified'])->get('error', [HomeController::class, 'error'])->name('error');



/* --Route::get('/indicadorkpi', [App\Http\Controllers\IndicadorkpiController::class, 'index'])->name('indicadorkpi'); */
Route::middleware(['auth', 'verified'])->get('indicadorkpis', [IndicadorkpiController::class, 'index'])->name('indicadorkpis');
Route::middleware(['auth', 'verified'])->get('indicadorkpis/index', [IndicadorkpiController::class, 'index'])->name('indicadorkpis.index');
Route::middleware(['auth', 'verified'])->get('indicadorkpis/create', [IndicadorkpiController::class, 'create'])->name('indicadorkpis.create');
Route::middleware(['auth', 'verified'])->get('indicadorkpis/store', [IndicadorkpiController::class, 'store'])->name('indicadorkpis.store');
Route::middleware(['auth', 'verified'])->post('indicadorkpis/store', [IndicadorkpiController::class, 'store'])->name('indicadorkpis.store');
Route::middleware(['auth', 'verified'])->get('indicadorkpis/destroy', [IndicadorkpiController::class, 'destroy'])->name('indicadorkpis.destroy');
Route::middleware(['auth', 'verified'])->delete('indicadorkpis/destroy/{id}', [IndicadorkpiController::class, 'destroy'])->name('indicadorkpis.destroy');

Route::middleware(['auth', 'verified'])->get('indicadorkpis/show/{id}', [IndicadorkpiController::class, 'show'])->name('indicadorkpis.show');
Route::middleware(['auth', 'verified'])->get('indicadorkpis/edit/{id}', [IndicadorkpiController::class, 'edit'])->name('indicadorkpis.edit');
Route::middleware(['auth', 'verified'])->put('indicadorkpis/update/{id}', [IndicadorkpiController::class, 'update'])->name('indicadorkpis.update');
Route::middleware(['auth', 'verified'])->put('indicadorkpis/update/{indicadorkpi}', [IndicadorkpiController::class, 'update'])->name('indicadorkpis.update');
Route::middleware(['auth', 'verified'])->patch('indicadorkpis/update/{indicadorkpi}', [IndicadorkpiController::class, 'update'])->name('indicadorkpis.update');

Route::middleware(['auth', 'verified'])->get('diariokpis', [DiariokpiController::class, 'index'])->name('diariokpis');
Route::middleware(['auth', 'verified'])->get('diariokpis/index/{kpiid}/{formato}', [DiariokpiController::class, 'index'])->name('diariokpis.index');
//Route::middleware(['auth', 'verified'])->get('diariokpis/index/{diariokpi}', [DiariokpiController::class, 'index'])->name('diariokpis.index');
Route::middleware(['auth', 'verified'])->get('diariokpis/modal/{kpiid}/{formato}/{local}', [DiariokpiController::class, 'modal'])->name('diariokpis.modal');

Route::middleware(['auth', 'verified'])->get('diariokpis/listadiarioall/{kpiid}', [DiariokpiController::class, 'listadiarioall'])->name('diariokpis.listadiarioall');


Route::middleware(['auth', 'verified'])->get('historicokpis/index/{id}', [HistoricokpiController::class, 'index'])->name('historicokpis.index');

Route::middleware(['auth', 'verified'])->get('mensualkpis/index/{id}', [MensualkpiController::class, 'index'])->name('mensualkpis.index');
/* Route::middleware(['auth', 'verified'])->get('mensualkpis/index/{kpiid}/{formato}', [MensualkpiController::class, 'index'])->name('mensualkpis.index'); */
Route::middleware(['auth', 'verified'])->get('mensualkpis/modal/{kpiid}/{formato}/{local}', [MensualkpiController::class, 'modal'])->name('mensualkpis.modal');


Route::middleware(['auth', 'verified'])->get('historicokpis/modal/{kpiid}/{formato}/{local}', [HistoricokpiController::class, 'modal'])->name('historicokpis.modal');


Route::middleware(['auth', 'verified'])->get('reportes', [ReporteController::class, 'index'])->name('reportes');
Route::middleware(['auth', 'verified'])->get('localesbyid/{id}/{formato}', [ReporteController::class, 'localesbyid'])->name('localesbyid');
Route::middleware(['auth', 'verified'])->get('reportes/{kpiid}/{formato}/{local}', [ReporteController::class, 'local'])->name('reportesLocal');


Route::middleware(['auth', 'verified'])->get('exportExcel/{kpiid}/{formato}/{local}/{archivoExcel}', [DiariokpiController::class, 'exportExcel'])->name('exportExcel');
Route::middleware(['auth', 'verified'])->get('exportExcelHistorico/{kpiid}/{formato}/{local}/{archivoExcel}', [HistoricokpiController::class, 'exportExcel'])->name('exportExcelHistorico');
Route::middleware(['auth', 'verified'])->get('exportExcelMensual/{kpiid}/{formato}/{local}/{archivoExcel}', [MensualkpiController::class, 'exportExcel'])->name('exportExcelMensual');


Route::middleware(['auth', 'verified'])->get('formatoall/{id}/{formato}', [HomeController::class, 'formatoall'])->name('formatoall');
Route::middleware(['auth', 'verified'])->get('formatoDetalle/{kpiid}/{formato}', [HomeController::class, 'formatoDetalle'])->name('formatoDetalle');

