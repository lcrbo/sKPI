
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
                <h3 class="card-title">historico {{$kpi->nombre}}  </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="float-right">
                <a class="btn btn-success" href="{{ route('kpi',$kpi->id) }}" role="button">Volver</a>
              </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Formato</th>
                    <th>Local</th>
                    <th>KPI</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($historicokpis as $historicokpi)
                    <tr>
                    <td>{{ date("d-m-Y", strtotime($historicokpi->fecha)) }}</td>
                        <td>
                        <a href="" > {{ $historicokpi->formato }} </a>
                        
                        
                        </td>
                        <td>
                        <a href="" > {{ $historicokpi->local }} </a>
                        
                        
                        </td>
                    @if ( $historicokpi->valor   < 80 )
                        
                        <td><span class=" bg-danger">{{ $historicokpi->valor }} {{ $kpi->formato }}</span></td>
                        
                    @elseif (( $historicokpi->valor  >= 80) && ( $historicokpi->valor   < 90))
                        
                        
                        <td>
                            <span class=" bg-warning">{{ $historicokpi->valor }} {{ $kpi->formato }}</span>
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
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

     

    </section>
    <!-- /.content -->

    </x-slot> 
</x-master-layout>
