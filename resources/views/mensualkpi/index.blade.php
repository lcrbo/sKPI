<x-master-layout> 
<x-slot name="stylesheet">

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">


  </x-slot>


    <x-slot name="slot">

    <!-- TITULO -->

    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-6" >
              <ol class="breadcrumb float-sm-left">
              <li ><h1 class="m-0">KPI  {{$kpi->nombre}}  </h1></li>
                <li ><small class="small-box-footer">&nbsp;&nbsp;&nbsp;  [ Última Actualización {{ date("d-m-Y", strtotime($ultimoFecha)) }}  {{ date("H:i A", strtotime($ultimoHora)) }} ] </small></li> 
              </ol>
           </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">KPI  {{$kpi->nombre}} </li>  
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Detalle {{$kpi->nombre}} {{$lformato}} por mes</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="float-right">

              <div class="row">
                <div class="col-lg-6">
                  <form action="{{ route('mensualkpis.index', $kpi->id) }}" method="GET" class="navbar-form navbar-left" role="search">
                    <div class="input-group small">
                      <input class="form-check-input input-sm" style="display:none;"  type="radio" name="formato" checked
                            <?php if (isset($formato) && $formato=="{{$lformato}}") echo "checked";?>
                            value="{{$lformato}}">
                            <input name="umbralCritico" style="display:none; " class="form-check-input input-sm" value="{{$kpi->umbral2}}" type="checkbox" checked >
                            <input name="umbralMedio" style="display:none;"  class="form-check-input input-sm" value="{{$kpi->umbral3}}" type="checkbox"  checked >
                            <input name="umbralBajo" style="display:none;"  class="form-check-input input-sm" value="{{$kpi->umbral3}}" type="checkbox" checked >
                      <input name="local" type="text" class="form-control input-sm" placeholder="busqueda">
                      <div class="input-group-append">
                                <button type="submit" class="btn btn-default btn-sm">
                                    <i class="fa fa-search"></i>
                                </button>
                      </div>
                    </div>
                    
                  </form>
                </div>  
                <div class="col-lg-6">
                  <a class="btn btn-success btn-sm" href="{{ route('kpi',$kpi->id) }}" role="button">
                  <i class="fas fa-arrow-left"></i>
                  Volver</a>
                </div>
              </div>


                
              </div>
                <table id="mensualcontrolxxx" class="table table-bordered table-striped">
                  <thead>
                  <tr>
           
                    
                    <th>Tienda</th>
                    <th>KPI (Último)</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($mensualkpis as $mensualkpi)
                    <tr>
                    @if ( $mensualkpi->valor   < $kpi->umbral2 )
                     
                        <!-- <td>
                        <a href="" > {{ $mensualkpi->formato }} </a>
                        </td> -->
                        <td>
                        <a href="{{ route('mensualkpis.modal', [ 'kpiid'=>$mensualkpi->indicadorkpi_id , 'formato'=>$lformato , 'local'=>$mensualkpi->local ] ) }}" > {{ $mensualkpi->local }} </a>
                        </td>
                        <td>
                          <span class=" bg-danger">{{ round($mensualkpi->valor,2) }} {{ $kpi->formato }}</span>
                          <div class="progress progress-xs" style="height:5px">
                            <div class="progress-bar bg-danger" style="width: {{ $mensualkpi->valor }}{{ $kpi->formato }}"></div>
                          </div>
                        </td>
                        
                    @elseif (( $mensualkpi->valor  >= $kpi->umbral2) && ( $mensualkpi->valor   < $kpi->umbral3))
                        
                        <!-- <td>
                        <a href="" > {{ $mensualkpi->formato }} </a>
                        </td> -->
                        <td >
                        <a href="{{ route('mensualkpis.modal', [ 'kpiid'=>$mensualkpi->indicadorkpi_id , 'formato'=>$lformato , 'local'=>$mensualkpi->local ] ) }}" > {{ $mensualkpi->local }} </a>
                        </td>
                        <td>
                          <span class=" bg-warning">{{ round($mensualkpi->valor,2) }} {{ $kpi->formato }}</span>
                          <div class="progress progress-xs" style="height:5px">
                            <div class="progress-bar bg-warning" style="width: {{ $mensualkpi->valor }}{{ $kpi->formato }}"></div>
                          </div>
                        </td>
                    @elseif ( $mensualkpi->valor  >= $kpi->umbral3)
                        
                        
                        <td >
                        <a href="{{ route('mensualkpis.modal', [ 'kpiid'=>$mensualkpi->indicadorkpi_id , 'formato'=>$lformato , 'local'=>$mensualkpi->local ] ) }}" > {{ $mensualkpi->local }} </a>
                        </td>
                        <td>
                          <span class=" bg-success">{{ round($mensualkpi->valor,2) }} {{ $kpi->formato }}</span>
                          <div class="progress progress-xs" style="height:5px">
                            <div class="progress-bar bg-success" style="width: {{ $mensualkpi->valor }}{{ $kpi->formato }}"></div>
                          </div>
                        </td>  
                            
                    @endif
                    </tr>
                @endforeach
                  

                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            
            <!-- /.card -->
          </div>
          {!! $mensualkpis->appends(request()->all())->links('pagination') !!}
         
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

     

    </section>
    <!-- /.content -->



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



  </x-slot> 
</x-master-layout>
