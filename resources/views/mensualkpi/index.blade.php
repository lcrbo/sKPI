<x-master-layout> 
  <x-slot name="lista"> 
        @foreach ($indicadorkpis as $indicadorkpi)
            <li class="nav-item">
            @if ($indicadorkpi->id == $kpi->id)
            <a href="{{ route('kpi',$indicadorkpi->id) }}"  class="nav-link active" >
            @else
            <a href="{{ route('kpi',$indicadorkpi->id) }}"  class="nav-link " >
            @endif
                <i class="far fa-compass nav-icon"></i>
                <p>{{ $indicadorkpi->nombre }} </p>
            </a>
            </li>
        @endforeach
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
                          <span class=" bg-danger">{{ $mensualkpi->valor }} {{ $kpi->formato }}</span>
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
                          <span class=" bg-warning">{{ $mensualkpi->valor }} {{ $kpi->formato }}</span>
                          <div class="progress progress-xs" style="height:5px">
                            <div class="progress-bar bg-warning" style="width: {{ $mensualkpi->valor }}{{ $kpi->formato }}"></div>
                          </div>
                        </td>
                    @elseif ( $mensualkpi->valor  >= $kpi->umbral3)
                        
                        
                        <td >
                        <a href="{{ route('mensualkpis.modal', [ 'kpiid'=>$mensualkpi->indicadorkpi_id , 'formato'=>$lformato , 'local'=>$mensualkpi->local ] ) }}" > {{ $mensualkpi->local }} </a>
                        </td>
                        <td>
                          <span class=" bg-success">{{ $mensualkpi->valor }} {{ $kpi->formato }}</span>
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






  </x-slot> 
</x-master-layout>
