    

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
                <h3 class="card-title">Detalle {{$kpi->nombre}} : {{$locales[0]->formato}}, local {{$locales[0]->local}}</h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              

              <div class="chartD" id="revenue-chart"
                       style="position: relative; height: 300px;">
                    <div id="lineChartDiario" style="position: relative; height: 300px;"></div>
                  </div>
                  <div class="float-right">
                <a class="btn btn-success" href="{{ URL::previous() }}" role="button">Volver</a>
              </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Hora</th>
                    <th>Local</th>
                    <th>KPI</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($locales as $locale)
                    <tr>
                    @if ( $locale->valor   < 80 )
                        <td>{{ $locale->hora }}</td>
                        <td>
                        {{ $locale->local }} 
                        
                        
                        </td>
                        <td><span class=" bg-danger">{{ $locale->valor }} {{ $kpi->formato }}</span></td>
                        
                    @elseif (( $locale->valor  >= 80) && ( $locale->valor   < 90))
                        <td>{{ $locale->hora }}</td>
                        <td >
                        {{ $locale->local }} <
                        
                        </td>
                        <td>
                            <span class=" bg-warning">{{ $locale->valor }} {{ $kpi->formato }}</span>
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



    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

        var collectionDiario = <?php echo $collectionDiario; ?>;
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(lineChart);
        

        function lineChart() {
            var data = google.visualization.arrayToDataTable(collectionDiario);
            var options = {
              displayLegendDots: true,
                responsive: true,
                curveType: 'function',
                title: '',
                
                legend: {
                    position: 'right'
                },
                pointSize: 3,
                hAxis: {
                  title: 'Hora Medición',
                  viewWindow: { max: [12] },
                  
                },
               
                vAxis: {
                    title: '{{$kpi->descripcionsyb}} ',
                    viewWindow: {'min': 0, 'max': 100},
                    
                    
                },
                table: {
                  sortAscending: true,
                 
                       }
              
                
            };
            var chartD = new google.visualization.LineChart(document.getElementById('lineChartDiario'));
            chartD.draw(data, options);
            
        }  

        
</script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>




    </x-slot> 
</x-master-layout>
