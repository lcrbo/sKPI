<x-master-layout>


  <x-slot name="stylesheet">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  </x-slot>


  <x-slot name="slot">


    <x-contenttitulo> Reporte
      <x-slot name="fechaActualizacion"></x-slot>

    </x-contenttitulo>



    <section class="content">

      <div class="content-header">
        <div class="container-fluid">
          <div id="content" align="center">
            <h1 class="m-0 ">Reporte {{$kpi->nombre}} </h1>
            <small class="small-box-footer"> Última Actualización {{ date("d-m-Y", strtotime($ultimoFecha)) }} {{ date("H:i A", strtotime($ultimoHora)) }}</small>
          </div>
          <div id="content" align="center">
            <div class="col-lg-3 col-6">
              <h1 class="m-0">{{$lformato}} : Local {{$llocal}} </h1>
            </div>

          </div>
        </div><!-- /.container-fluid -->
      </div>

      <div id="content">
        <div class="row">

          <div class="col-lg-4 "></div>

          <div class="col-lg-4 ">
            @if ($ultimoFecha < date('Y-m-d')) 
            <div class="small-box bg-success">
              <div class="inner">
                <h3>S/I</h3>
                <h2>&nbsp;</h2>
              </div>
              <div class="icon">
                <i class="">
                  <img src="{{ asset('/img/'.$diariokpis[0]->formato.'-gris.png') }}" alt="" class="rounded mx-auto d-block" width="100" height="100" style="opacity: .8">
                </i>
              </div>
          </div>
          @else
            @if ( $diariokpis[0]->average < $kpi->umbral2 )
            <div class="small-box bg-danger" ">  
            @elseif (( $diariokpis[0]->average  >= $kpi->umbral2) && ( $diariokpis[0]->average  < $kpi->umbral3))
            <div class=" small-box bg-warning">
            @else ( $diariokpis[0]->average >= $kpi->umbral3)
            <div class="small-box bg-success">
            @endif
          
            <div class="inner">
              <h3>{{ $diariokpis[0]->average }}{{$kpi->formato}}</h3>
              <h2>&nbsp;</h2>
            </div>
            <div class="icon">
              <i class="">
                <img src="{{ asset('/img/'.$diariokpis[0]->formato.'-gris.png') }}" alt="" class="rounded mx-auto d-block" width="100" height="100" style="opacity: .8">
              </i>
            </div>
          </div>
          @endif
        </div>
        <div class="col-lg-4   "></div>



      </div>
      </div>






      <div class="card-header border-0">
        <div class="card-tools right">

          <a class="btn btn-secondary btn-sm" role="button" id="exportpdf">
            <i class="far fa-file-pdf"></i>
            Reporte PDF
          </a>
        </div>
      </div>


      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>

                  </h3>
                  <div class="card-tools">
                    <a class="btn btn-secondary btn-sm" role="button" id="exportpdfD" title="Gráfico PDF">
                      <i class="far fa-file-pdf"></i>
                    </a>
                    <a class="btn btn-secondary btn-sm" href="{{ route('exportExcel', [ 'kpiid'=>$kpi->id , 'formato'=>$lformato , 'local' => $llocal, 'archivoExcel' => $kpi->nombre. ' por hora '. $lformato .' '. $llocal .' ' . date('d-m-Y')  ]) }}" role="button" title="Exportar Excel">
                      <i class="far fa-file-excel"></i>
                    </a>
                    <!--  <button type="button" class="btn bg-primary btn-sm" data-toggle="modal" data-target="#modal-diario"  title="Detalle">
                  <i class="far fa-file-alt"></i>
                  </button> -->
                    <button type="button" class="btn bg-info btn-sm" id="changeColumnD" title="Gráfico barras">
                      <i class="fas fa-chart-bar"></i>
                    </button>
                    <button type="button" class="btn bg-info btn-sm" id="changeSpLineD" title="Gráfico Líneas">
                      <i class="fas fa-chart-line"></i>
                    </button>

                  </div>
                </div>
                <div class="card-body">
                  @if ( $ultimoFecha < date('Y-m-d') ) <div class="alert alert-danger bg-danger fade show" role="alert">
                    <strong>ATENCIÓN! </strong> {{$kpi->errorsindata}}

                </div>
                @else
                <figure class="highcharts-figure">
                  <div id="containerD"></div>
                </figure>

                @endif
              </div>
            </div>

            <form action="{{ route('reportesLocal', [ 'kpiid'=>$kpi->id , 'formato'=>$lformato , 'local' => $llocal  ]) }}" method="GET" class="navbar-form navbar-left" id="myform" name="myform">

              <!-- historico -->
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>

                  </h3>
                  <div class="card-tools">
                    <a class="btn btn-secondary btn-sm" role="button" id="exportpdfH" title="Gráfico PDF">
                      <i class="far fa-file-pdf"></i>
                    </a>
                    <a class="btn btn-secondary btn-sm" href="{{ route('exportExcelHistorico', [ 'kpiid'=>$kpi->id , 'formato'=>$lformato , 'local' => $llocal, 'archivoExcel' => $kpi->nombre. ' por dia '. $lformato .' '. $llocal .' ' . date('d-m-Y')  ]) }}" role="button" title="Exportar Excel">
                      <i class="far fa-file-excel"></i>
                    </a>
                    <input id="startDateH" name="startDateH" type="hidden">
                    <input id="endDateH" name="endDateH" type="hidden">
                    <a type="submit" class="btn btn-secondary btn-sm" role="button" id="daterange-btn-h" title="Rango dias">
                      <i class="far fa-calendar-alt"></i>
                      Rango dias
                    </a>
                    <button type="submit" class="btn btn-default btn-sm" id="hinddenBtnH" style=" visibility: hidden">
                    </button>
                    <button type="button" class="btn bg-info btn-sm" id="changeColumnH" title="Grágfico barras">
                      <i class="fas fa-chart-bar"></i>
                    </button>
                    <button type="button" class="btn bg-info btn-sm" id="changeSpLineH" title="Grágfico líneas">
                      <i class="fas fa-chart-line"></i>
                    </button>

                  </div>
                </div>
                <div class="card-body">
                  @if ( $fechasH->first() == null )
                  <div class="alert alert-danger bg-danger fade show" role="alert">
                    <strong>ATENCIÓN! </strong> {{$kpi->errorsindata}}

                  </div>
                  @else
                  <figure class="highcharts-figure">
                    <div id="containerH"></div>
                  </figure>
                  @endif
                </div>
              </div>

              <!-- MENSUAL -->
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">
                    <i class="fas fa-chart-line"></i>
                  </h3>
                  <div class="card-tools">
                    <a class="btn btn-secondary btn-sm" role="button" id="exportpdfM" title="Gráfico PDF">
                      <i class="far fa-file-pdf"></i>
                    </a>
                    <a class="btn btn-secondary btn-sm" href="{{ route('exportExcelMensual', [ 'kpiid'=>$kpi->id , 'formato'=>$lformato , 'local' => $llocal, 'archivoExcel' => $kpi->nombre. ' por dia '. $lformato .' '. $llocal .' ' . date('d-m-Y')  ]) }}" role="button" title="Exportar Excel">
                      <i class="far fa-file-excel"></i>
                    </a>

                    <input id="startDateM" name="startDateM" type="hidden">
                    <input id="endDateM" name="endDateM" type="hidden">
                    <a type="submit" class="btn btn-secondary btn-sm" role="button" id="daterange-btn-m" title="Rango Meses">
                      <i class="far fa-calendar-alt"></i>
                      Rango Meses
                    </a>
                    <button type="submit" class="btn btn-default btn-sm" id="hinddenBtnM" style=" visibility: hidden">
                    </button>
                    <button type="button" class="btn bg-info btn-sm" id="changeColumnM" title="Grágfico barras">
                      <i class="fas fa-chart-bar"></i>
                    </button>
                    <button type="button" class="btn bg-info btn-sm" id="changeSpLineM" title="Grágfico líneas">
                      <i class="fas fa-chart-line"></i>
                    </button>

                  </div>
                </div>
                <div class="card-body">
                  @if ( $fechasM->first() == null )
                  <div class="alert alert-danger bg-danger fade show" role="alert">
                    <strong>ATENCIÓN! </strong> {{$kpi->errorsindata}}

                  </div>
                  @else
                  <figure class="highcharts-figure">
                    <div id="containerM"></div>
                  </figure>
                  @endif
                </div>
              </div>

            </form>

          </div>


          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->


      </div>






      </div>


      <!-- modal -->
      <div class="modal fade" id="modal-diario">
        <div class="modal-dialog modal-lg">
          <form action="{{ route('diariokpis.listadiarioall', $kpi->id) }}" method="GET">
            <div class="modal-content">
              <div class="card">
                <div class="card-header border-1">
                  <h3 class="card-title">
                    <i class="fas fa-search-plus"></i>
                    Criterios de Selección {{$kpi->nombre}}
                  </h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">Seleccionar un Formato</h3>

                    </div>
                    <div class="card-body">
                      <div class="form-group">

                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" checked <?php if (isset($formato) && $formato == "ALV") echo "checked"; ?> value="ALV">
                          <label class="form-check-label">Alvi</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "M10") echo "checked"; ?> value="M10">
                          <label class="form-check-label">Mayorista 10</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "OKM") echo "checked"; ?> value="OKM">
                          <label class="form-check-label">OKMarket</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "UNI") echo "checked"; ?> value="UNI">
                          <label class="form-check-label">Unimarc</label>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- derecha column -->
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">
                        Seleccionar Umbrales
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="form-check">
                        <input name="umbralCritico" class="form-check-input" value="{{$kpi->umbral2}}" type="checkbox" checked>
                        <label class="form-check-label">Umbral Crítico [ valor <= {{$kpi->umbral2}}]</label>
                      </div>
                      <div class="form-check">
                        <input name="umbralMedio" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox" checked>
                        <label class="form-check-label">Umbral Medio [{{$kpi->umbral2}} > valor <= {{$kpi->umbral3}}]</label>
                      </div>
                      <div class="form-check">
                        <input name="umbralBajo" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox">
                        <label class="form-check-label">Umbral Bajo [ valor > {{$kpi->umbral3}}]</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar </button>
                <button type="submit" class="btn btn-primary">
                  Filtrar

                </button>
              </div>

            </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



      <!-- modal -->
      <div class="modal fade" id="modal-historico">
        <div class="modal-dialog modal-lg">
          <form action="{{ route('historicokpis.index', $kpi->id) }}" method="GET">
            <div class="modal-content">
              <div class="card">
                <div class="card-header border-1">
                  <h3 class="card-title">
                    <i class="fas fa-search-plus"></i>
                    Criterios de Selección {{$kpi->nombre}}
                  </h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">Seleccionar un Formato</h3>

                    </div>
                    <div class="card-body">
                      <div class="form-group">

                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" checked <?php if (isset($formato) && $formato == "ALV") echo "checked"; ?> value="ALV">
                          <label class="form-check-label">Alvi</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "M10") echo "checked"; ?> value="M10">
                          <label class="form-check-label">Mayorista 10</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "OKM") echo "checked"; ?> value="OKM">
                          <label class="form-check-label">OKMarket</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "UNI") echo "checked"; ?> value="UNI">
                          <label class="form-check-label">Unimarc</label>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- derecha column -->
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">
                        Seleccionar Umbrales
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="form-check">
                        <input name="umbralCritico" class="form-check-input" value="{{$kpi->umbral2}}" type="checkbox" checked>
                        <label class="form-check-label">Umbral Crítico [ valor <= {{$kpi->umbral2}}]</label>
                      </div>
                      <div class="form-check">
                        <input name="umbralMedio" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox" checked>
                        <label class="form-check-label">Umbral Medio [{{$kpi->umbral3}} > valor <= {{$kpi->umbral3}}]</label>
                      </div>
                      <div class="form-check">
                        <input name="umbralBajo" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox">
                        <label class="form-check-label">Umbral Bajo [ valor > {{$kpi->umbral3}}]</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar </button>
                <button type="submit" class="btn btn-primary">
                  Filtrar

                </button>
              </div>

            </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


      <!-- modal -->
      <div class="modal fade" id="modal-mensual">
        <div class="modal-dialog modal-lg">
          <form action="{{ route('mensualkpis.index', $kpi->id) }}" method="GET">
            <div class="modal-content">
              <div class="card">
                <div class="card-header border-1">
                  <h3 class="card-title">
                    <i class="fas fa-search-plus"></i>
                    Criterios de Selección {{$kpi->nombre}}
                  </h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">Seleccionar un Formato</h3>

                    </div>
                    <div class="card-body">
                      <div class="form-group">

                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" checked <?php if (isset($formato) && $formato == "ALV") echo "checked"; ?> value="ALV">
                          <label class="form-check-label">Alvi</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "M10") echo "checked"; ?> value="M10">
                          <label class="form-check-label">Mayorista 10</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "OKM") echo "checked"; ?> value="OKM">
                          <label class="form-check-label">OKMarket</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" <?php if (isset($formato) && $formato == "UNI") echo "checked"; ?> value="UNI">
                          <label class="form-check-label">Unimarc</label>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- derecha column -->
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">
                        Seleccionar Umbrales
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="form-check">
                        <input name="umbralCritico" class="form-check-input" value="{{$kpi->umbral2}}" type="checkbox" checked>
                        <label class="form-check-label">Umbral Crítico [ valor <= {{$kpi->umbral2}}]</label>
                      </div>
                      <div class="form-check">
                        <input name="umbralMedio" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox" checked>
                        <label class="form-check-label">Umbral Medio [ {{$kpi->umbral3}} > valor <= {{$kpi->umbral3}}]</label>
                      </div>
                      <div class="form-check">
                        <input name="umbralBajo" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox">
                        <label class="form-check-label">Umbral Bajo [ valor > {{$kpi->umbral3}}]</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar </button>
                <button type="submit" class="btn btn-primary">
                  Filtrar

                </button>
              </div>

            </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- small modal -->
      <div class="modal fade" id="modal-diario-ALV">
        <div class="modal-dialog modal-lm">
          <form action="{{ route('diariokpis.index',[ 'kpiid'=>$kpi->id , 'formato'=>$kpi->formato]) }}" method="GET">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Criterios de Selección </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="formato" checked <?php if (isset($formato) && $formato == "ALV") echo "checked"; ?> value="ALV">
                  <label class="form-check-label">Alvi</label>
                </div>
                <div class="card">
                  <div class="card-header border-1">
                    <h3 class="card-title">
                      Seleccionar Umbrales
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="form-check">
                      <input name="umbralCritico" class="form-check-input" value="{{$kpi->umbral2}}" type="checkbox" checked>
                      <label class="form-check-label">Umbral Crítico [valor <= {{$kpi->umbral2}}]</label>
                    </div>
                    <div class="form-check">
                      <input name="umbralMedio" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox" checked>
                      <label class="form-check-label">Umbral Medio [{{$kpi->umbral2}} > valor <= {{$kpi->umbral3}}]</label>
                    </div>
                    <div class="form-check">
                      <input name="umbralBajo" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox">
                      <label class="form-check-label">Umbral Bajo [ valor > {{$kpi->umbral3}}]</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar </button>
                <button type="submit" class="btn btn-primary">
                  Filtrar

                </button>
              </div>
            </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <!-- small modal -->
      <div class="modal fade" id="modal-diario-M10">
        <div class="modal-dialog modal-sm">
          <form action="{{ route('diariokpis.index',[ 'kpiid'=>$kpi->id , 'formato'=>$kpi->formato]) }}" method="GET">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Criterios de Selección {{$kpi->nombre}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="formato" checked <?php if (isset($formato) && $formato == "M10") echo "checked"; ?> value="M10">
                  <label class="form-check-label">M10</label>
                </div>
                <div class="card">
                  <div class="card-header border-1">
                    <h3 class="card-title">
                      Seleccionar Umbrales
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="form-check">
                      <input name="umbralCritico" class="form-check-input" value="{{$kpi->umbral2}}" type="checkbox" checked>
                      <label class="form-check-label">Umbral Crítico <= {{$kpi->umbral2}}</label>
                    </div>
                    <div class="form-check">
                      <input name="umbralMedio" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox" checked>
                      <label class="form-check-label">Umbral Medio <= {{$kpi->umbral3}}</label>
                    </div>
                    <div class="form-check">
                      <input name="umbralBajo" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox">
                      <label class="form-check-label">Umbral Bajo > {{$kpi->umbral3}}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar </button>
                <button type="submit" class="btn btn-primary">
                  Filtrar

                </button>
              </div>
            </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- small modal -->
      <div class="modal fade" id="modal-diario-OKM">
        <div class="modal-dialog modal-sm">
          <form action="{{ route('diariokpis.index',[ 'kpiid'=>$kpi->id , 'formato'=>$kpi->formato]) }}" method="GET">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Criterios de Selección {{$kpi->nombre}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="formato" checked <?php if (isset($formato) && $formato == "OKM") echo "checked"; ?> value="OKM">
                  <label class="form-check-label">OKM</label>
                </div>
                <div class="card">
                  <div class="card-header border-1">
                    <h3 class="card-title">
                      Seleccionar Umbrales
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="form-check">
                      <input name="umbralCritico" class="form-check-input" value="{{$kpi->umbral2}}" type="checkbox" checked>
                      <label class="form-check-label">Umbral Crítico <= {{$kpi->umbral2}}</label>
                    </div>
                    <div class="form-check">
                      <input name="umbralMedio" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox" checked>
                      <label class="form-check-label">Umbral Medio <= {{$kpi->umbral3}}</label>
                    </div>
                    <div class="form-check">
                      <input name="umbralBajo" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox">
                      <label class="form-check-label">Umbral Bajo > {{$kpi->umbral3}}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar </button>
                <button type="submit" class="btn btn-primary">
                  Filtrar

                </button>
              </div>
            </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <!-- small modal -->
      <div class="modal fade" id="modal-diario-UNI">
        <div class="modal-dialog modal-sm">
          <form action="{{ route('diariokpis.index',[ 'kpiid'=>$kpi->id , 'formato'=>$kpi->formato]) }}" method="GET">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Criterios de Selección {{$kpi->nombre}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="formato" checked <?php if (isset($formato) && $formato == "UNI") echo "checked"; ?> value="UNI">
                  <label class="form-check-label">UNI</label>
                </div>
                <div class="card">
                  <div class="card-header border-1">
                    <h3 class="card-title">
                      Seleccionar Umbrales
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="form-check">
                      <input name="umbralCritico" class="form-check-input" value="{{$kpi->umbral2}}" type="checkbox" checked>
                      <label class="form-check-label">Umbral Crítico <= {{$kpi->umbral2}}</label>
                    </div>
                    <div class="form-check">
                      <input name="umbralMedio" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox" checked>
                      <label class="form-check-label">Umbral Medio <= {{$kpi->umbral3}}</label>
                    </div>
                    <div class="form-check">
                      <input name="umbralBajo" class="form-check-input" value="{{$kpi->umbral3}}" type="checkbox">
                      <label class="form-check-label">Umbral Bajo > {{$kpi->umbral3}}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar </button>
                <button type="submit" class="btn btn-primary">
                  Filtrar

                </button>
              </div>
            </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

    </section>
    <!-- /.content -->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <!-- CHART HIGHCHARTS -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>








    <script type="text/javascript">
      Highcharts.getSVG = function(charts) {
        let top = 0;
        let width = 0;

        const groups = charts.map(chart => {
          let svg = chart.getSVG();
          // Get width/height of SVG for export
          const svgWidth = +svg.match(
            /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
          )[1];
          const svgHeight = +svg.match(
            /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
          )[1];

          svg = svg
            .replace(
              '<svg',
              '<g transform="translate(0,' + top + ')" '
            )
            .replace('</svg>', '</g>');

          top += svgHeight;
          width = Math.max(width, svgWidth);

          return svg;
        }).join('');

        return `<svg height="${top}" width="${width}" version="1.1"
        xmlns="http://www.w3.org/2000/svg">
            ${groups}
        </svg>`;
      };


      Highcharts.exportCharts = function(charts, options) {

        // Merge the options
        options = Highcharts.merge(Highcharts.getOptions().exporting, options);

        // Post to export server
        Highcharts.post(options.url, {
          filename: options.filename || 'reporte {{$kpi->nombre}}  ',
          type: options.type,
          width: options.width,
          svg: Highcharts.getSVG(charts)
        });
      };

      document.getElementById("exportpdf").addEventListener("click", function() {
        Highcharts.exportCharts([chartD, chartH, chartM], {
          type: 'application/pdf'
        });
      });

      document.getElementById("exportpdfD").addEventListener("click", function() {
        Highcharts.exportCharts([chartD], {
          type: 'application/pdf'
        });
      });

      document.getElementById("exportpdfH").addEventListener("click", function() {
        Highcharts.exportCharts([chartH], {
          type: 'application/pdf'
        });
      });

      document.getElementById("exportpdfM").addEventListener("click", function() {
        Highcharts.exportCharts([chartM], {
          type: 'application/pdf'
        });
      });





      /* DIARIO */
      var categoriasD = <?php echo json_encode($fechasD) ?>;
      var alvD = <?php echo json_encode($alvD)  ?>;









      let chartD = Highcharts.chart('containerD', {
        chart: {
          type: 'spline',
          scrollablePlotArea: {
            minWidth: 400,
            scrollPositionX: 1
          },
          events: {
            load: Highcharts.drawTable
          },
          borderWidth: 1,
          renderTo: 'containerD',
        },
        title: {
          text: '{{$kpi->nombre}} por hora de hoy {{ date("d-m-Y") }}'
        },
        subtitle: {
          text: '({{$kpi->descripcionsyb}}  x  hora medición )'
        },
        xAxis: {

          labels: {
            overflow: 'justify',
            formatter: function() {
                return this.value.substring(5,0) ;
              }
          },
          title: {
            text: 'Hora medición',
            style: {
              color: 'black'
            }
          },
          categories: categoriasD,
          floor: 0,
          ceiling: 48,
        },
        yAxis: {
          tickWidth: 1,
          lineWidth: 1,

          title: {
            text: '{{$kpi->descripcionsyb}}',
            style: {
              color: 'black'
            }

          },
          max: 100,
        },


        tooltip: {
          valueSuffix: ' {{$kpi->formato}}',
          split: true
        },



        plotOptions: {

          spline: {
            lineWidth: 4,
            states: {
              hover: {
                lineWidth: 5
              }
            },
            marker: {
              enabled: false
            },
            dataLabels: {
              enabled: true,
              format: '{y} {{$kpi->formato}}'
            }

          }
        },

        series: [{
          dataLabels: {
            enabled: true
          },
          name: '{{$lformato}}, local {{$llocal}}',
          label: {
            enabled: false,
          },
          shadow: false,
          color: '{{$color}}',
          data: alvD
        }],




        responsive: {
          rules: [{
            condition: {
              maxWidth: 500
            },
            chartOptions: {
              legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
              }
            }
          }]
        },

        exporting: {

          enabled: false,


        },

        credits: {
          enabled: false // Disable copyright information
        }

      });

      document.getElementById("changeColumnD").addEventListener("click", function() {
        chartD.series[0].update({
          type: 'column'
        });
      });
      document.getElementById("changeSpLineD").addEventListener("click", function() {
        chartD.series[0].update({
          type: 'spline'
        });
      });

      /* HISTORICO */
      var categoriasH = <?php echo json_encode($fechasH) ?>;
      var alvH = <?php echo json_encode($alvH)  ?>;




      let chartH = Highcharts.chart('containerH', {
        chart: {
          type: 'spline',
          scrollablePlotArea: {
            minWidth: 400,
            scrollPositionX: 1
          }
        },
        title: {
          text: '{{$kpi->nombre}} por día'
        },
        subtitle: {
          text: '(  {{$kpi->descripcionsyb}}  x  día medición )'
        },
        xAxis: {
          type: 'datetime',
          labels: {
            overflow: 'justify',
            formatter: function() {
                return this.value.substring(10,8) +'-'+this.value.substring(7,5) +'-'+this.value.substring(4,0) ;
              }
          },
          title: {
            text: 'Día medición',
            style: {
              color: 'black'
            }
          },
          categories: categoriasH,
          floor: 0,
          ceiling: 30,
        },
        yAxis: {
          tickWidth: 1,
          lineWidth: 1,

          title: {
            text: '{{$kpi->descripcionsyb}}',
            style: {
              color: 'black'
            }

          },
          max: 100,
        },
        tooltip: {
          valueSuffix: ' {{$kpi->formato}}',
          split: true
        },



        plotOptions: {
          spline: {
            lineWidth: 4,
            states: {
              hover: {
                lineWidth: 5
              }
            },
            marker: {
              enabled: false
            },
            dataLabels: {
              enabled: true,
              format: '{y} {{$kpi->formato}}'
            }
          }
        },
        series: [{
          dataLabels: {
            enabled: true
          },
          name: '{{$lformato}}, local {{$llocal}}',
          label: {
            enabled: false,
          },
          shadow: false,
          color: '{{$color}}',
          data: alvH
        }],

        responsive: {
          rules: [{
            condition: {
              maxWidth: 500
            },
            chartOptions: {
              legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
              }
            }
          }]
        },

        exporting: {
          enabled: false
        },

        credits: {
          enabled: false // Disable copyright information
        }



      });

      document.getElementById("changeColumnH").addEventListener("click", function() {
        chartH.series[0].update({
          type: 'column'
        });
      });
      document.getElementById("changeSpLineH").addEventListener("click", function() {
        chartH.series[0].update({
          type: 'spline'
        });
      });

      /* MENSUAL */
      var categoriasM = <?php echo json_encode($fechasM) ?>;
      var alvM = <?php echo json_encode($alvM) ?>;




      let chartM = Highcharts.chart('containerM', {
        chart: {
          type: 'spline',
          scrollablePlotArea: {
            minWidth: 400,
            scrollPositionX: 10
          }
        },
        title: {
          text: '{{$kpi->nombre}} por mes'
        },
        subtitle: {
          text: '(  {{$kpi->descripcionsyb}}  x  Mes medición )'
        },
        xAxis: {
          type: 'datetime',
          labels: {
            overflow: 'justify',
            formatter: function() {
                return this.value.substring(7,5) +'-'+this.value.substring(4,0) ;
              }
          },
          title: {
            text: 'Mes medición',
            style: {
              color: 'black'
            }
          },
          categories: categoriasM,
          offset: 0.1,
          floor: 0,
          ceiling: 12,
        },
        yAxis: {
          tickWidth: 1,
          lineWidth: 1,

          title: {
            text: '{{$kpi->descripcionsyb}}',
            style: {
              color: 'black'
            }

          },
          max: 100,
        },
        tooltip: {
          valueSuffix: ' {{$kpi->formato}}',
          split: true
        },



        plotOptions: {
          spline: {
            lineWidth: 4,
            states: {
              hover: {
                lineWidth: 5
              }
            },
            marker: {
              enabled: false
            },
            dataLabels: {
              enabled: true,
              format: '{y} {{$kpi->formato}}'
            }
          }
        },
        series: [{
          dataLabels: {
            enabled: true
          },
          name: '{{$lformato}}, local {{$llocal}}',
          label: {
            enabled: false,
          },
          shadow: false,
          color: '{{$color}}',
          data: alvM
        }],

        responsive: {
          rules: [{
            condition: {
              maxWidth: 500
            },
            chartOptions: {
              legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
              }
            }
          }]
        },

        exporting: {
          enabled: false
        },

        credits: {
          enabled: false // Disable copyright information
        }

      });

      document.getElementById("changeColumnM").addEventListener("click", function() {
        chartM.series[0].update({
          type: 'column'
        });
      });
      document.getElementById("changeSpLineM").addEventListener("click", function() {
        chartM.series[0].update({

          type: 'spline'
        });
      });
    </script>



    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/moment/locale/es.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- BS-Stepper -->
    <script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>





    <script type="text/javascript">
      $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
          'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
          'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
          format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
          icons: {
            time: 'far fa-clock'
          }
        });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
          }
        })
        $('#rangoHora').daterangepicker({
          language: 'es',

          startDate: moment(),
          endDate: moment(),
          datepicker: false,
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'HH:mm'
          }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
            language: 'es',
            ranges: {
              'Últimos 7 Meses': [moment().subtract(6, 'month'), moment()],
              'Último Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(1, 'month'),
            endDate: moment(),
            timePicker: true,
            datePicker: false,
          },
          function(start, end) {
            if (start != '') {
              $('#startDate').val(start.format('YYYY-MM-DD'));
              $('#endDate').val(end.format('YYYY-MM-DD'));
              $('#hinddenBtn').trigger("click");
            }
          }
        )

        $('#daterange-btn-h').daterangepicker({

            ranges: {
              'Últimos 7 Días': [moment().subtract(6, 'days'), moment()],


            },
            startDate: moment().subtract({{$kpi->diasmax}}, 'days'),
            endDate: moment(),
            minDate: moment().subtract({{$kpi->diasmax}}, 'days'),
            maxDate: moment(),
            timePicker: false,
            datePicker: false,
          },
          function(start, end) {
            if (start != '') {
              $('#startDateH').val(start.format('YYYY-MM-DD'));
              $('#endDateH').val(end.format('YYYY-MM-DD'));
              $('#hinddenBtnH').trigger("click");
            }
          }
        )
        //Timepicker
        $('#timepicker').datetimepicker({
          format: 'LT'
        })

        $('#daterange-btn-m').daterangepicker({
            language: 'es',
            showDropdowns: true,
            ranges: {

            },
            startDate: moment().subtract({{$kpi-> mesesmax}}, 'month'),
            endDate: moment(),
            minDate: moment().subtract({{$kpi->mesesmax}}, 'month'),
            maxDate: moment(),
            format: "mm-yyyy",
            startView: "months",
            minViewMode: "months"
          },
          function(start, end) {
            if (start != '') {
              $('#startDateM').val(start.format('YYYY-MM-01'));
              $('#endDateM').val(end.format('YYYY-MM-01'));
              $('#hinddenBtnM').trigger("click");
            }
          }
        )
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
          $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function() {
          $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

      })
      // BS-Stepper Init
      document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
      })
    </script>


  </x-slot>

</x-master-layout>