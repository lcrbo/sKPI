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


<x-contenttitulo> KPI  {{$kpi->nombre}} 
  <x-slot name="fechaActualizacion"> [ Última Actualización {{ date("d-m-Y", strtotime($ultimoFecha)) }}  {{ date("H:i A", strtotime($ultimoHora)) }}  ] </x-slot>
  
</x-contenttitulo>



<section class="content">

    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        @foreach ($diariokpis as $diariokpi)
          <div class="col-lg-3 col-6">
            @if (( $diariokpi->average < $kpi->umbral2 ) || ($ultimoFecha < date('Y-m-d')))
              <div class="small-box bg-danger">
            @elseif (( $diariokpi->average  >= $kpi->umbral2) && ( $diariokpi->average  <= $kpi->umbral3))
              <div class="small-box bg-warning">
            @else ( $diariokpi->average  >= $kpi->umbral3)
              <div class="small-box bg-success">
            @endif
                <div class="inner">
                  @if ($ultimoFecha < date('Y-m-d')) 
                    <h3>S/I <sup style="font-size: 20px">%</sup></h3>
                  @else
                    <h3>{{ $diariokpi->average }} <sup style="font-size: 20px">%</sup></h3>
                  @endif
                    <h2>{{ $diariokpi->formato }}</h2>
                </div>
                <div class="icon">
                <i class="">
                <img src="{{ asset('/img/'.$diariokpi->formato.'.png') }}" alt="" class="rounded mx-auto d-block" width="100" height="100" style="opacity: .8">
      
                    </i>
                </div>
                
                @if ($ultimoFecha < date('Y-m-d'))
                  <a href="#" class="small-box-footer">Sin Información para hoy </a>
                @else
                  <a href="{{ route('diariokpis.index',[ 'kpiid'=>$kpi->id , 'formato'=>$diariokpi->formato]) }}" class="small-box-footer">Detalle <i class="fas fa-arrow-circle-right"></i></a>
                @endif
              </div>
          </div>
          @endforeach
      </div>

      @if ( $ultimoFecha   <  date('Y-m-d') )
        <!-- ALERTA SIN INFORMACION PARA HOY -->
        <div class="alert alert-danger bg-danger fade show" role="alert">
            <strong>ATENCIÓN! </strong> NO EXISTE INFORMACIÓN PARA EL DÍA DE HOY.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div> 
      @endif

<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">



          <div class="card">
              <div class="card-header border-0">
              <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                   {{$kpi->nombre}} por hora de hoy {{ date("d-m-Y") }}
                </h3>
                <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" id="daterange" title="Rango fecha">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  
                  <button type="button" class="btn bg-info btn-sm"   title="Detalle">
                   <a href="{{ route('diariokpis.listadiarioall',$kpi->id) }}"  class="fas fa-file-alt" ></a> 
                   
                  </button>
                  
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  
                </div>
                </div>
                <div class="card-body">
                @if ( $ultimoFecha   <  date('Y-m-d') )
                  <div class="alert alert-danger bg-danger fade show" role="alert">
                    <strong>ATENCIÓN! </strong> NO EXISTE INFORMACIÓN PARA EL DÍA DE HOY. 
                    
                  </div>
                @else
                 <!--  <div class="chartD" id="revenue-chart"
                       style="position: relative; height: 300px;">
                    <div id="lineChartDiario" style="position: relative; height: 300px;"></div>
                  </div> -->
                  <div id="dashboard_lineChartDiario" style=" overflow-x  : scroll;" > 
                      <!--Divs that will hold each control and chart-->
                      
                      <div id="chart_lineChartDiario" ></div>
                      <div id="filter_lineChartDiario"></div>
                  </div>
                   
                @endif
                </div>
            </div>

          <div class="card">
              <div class="card-header border-0">
              <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  {{$kpi->nombre}} por día
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" title="Rango de Fechas">
                    <i class="far fa-calendar-alt"></i>
                    
                  </button>
                  <button type="button" class="btn bg-info btn-sm"   title="Detalle">
                  <a href="{{ route('historicokpis.index', $kpi->id) }}"  class="far fa-file-alt" ></a>
                  
                  </button>
                  
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  
                </div>
                </div>
                <div class="card-body">
                
                <div class="chart2" id="revenue-chart"
                       style="position: relative; height: 300px;">
                <div id="lineChartHistorico" style="position: relative; height: 300px;"></div>
                </div>
                
                </div>
            </div>
            
 
          


<!-- MENSUAL -->
  <div class="card">
              <div class="card-header border-0">
              <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  {{$kpi->nombre}} por mes
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" title="Rango de Fechas">
                    <i class="far fa-calendar-alt"></i>
                    
                  </button>
                  
                  <button type="button" class="btn bg-info btn-sm"   title="Detalle">
                  <a href="{{ route('mensualkpis.index', $kpi->id) }}"  class="far fa-file-alt" ></a>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  
                </div>
                </div>
                <div class="card-body">
                
                <!-- <div class="chartM" id="revenue-chart"
                       style="position: relative; height: 300px;">
                <div id="lineChartMensual" style="position: relative; height: 300px;"></div>
                </div> -->
                
                <div id="dashboard_div" style=" overflow-x  : scroll;">
                  <!--Divs that will hold each control and chart-->
                  
                  <div id="chart_div"></div>
                  <div id="filter_div"></div>
                </div>

                </div>
            </div>
            
 
          </div>


          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

        



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

        var collectionDiario = <?php echo $collectionDiario; ?>;
        /* google.charts.load('current', {
            'packages': ['corechart']
        }); */
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(lineChartD);
        

        function lineChartD() {

            var data = google.visualization.arrayToDataTable([
                  [ 'hora', 'ALV' , 'UNI', 'M10','OKM'],

                  <?php
                    $i=1;
                    foreach($c4 as $key => $val) {
                        echo "['".$val->hora."', ".$val->alv.", ".$val->uni.", ".$val->m10.", ".$val->okm."],";
                    }

                    ?>
              ]);


              var dashboard = new google.visualization.Dashboard(
                              document.getElementById('Dashboard_lineChartDiario'));

            var donutRangeSlider = new google.visualization.ControlWrapper({
              'controlType': 'CategoryFilter', /* NumberRangeFilter 'StringFilter',CategoryFilter */
              'containerId': 'filter_lineChartDiario',
              'options': {
                'filterColumnLabel': 'hora'
               }
           });

           var pieChart = new google.visualization.ChartWrapper({
              chartType: 'LineChart',
              containerId: 'chart_lineChartDiario',
               options : {
                
                  responsive: true,
                  curveType: 'function',
                  title: '',
                 
                  legend: {
                      position: 'right'
                  },
                  pointSize: 3, 
                  hAxis: {
                    title: 'hora Medición',
                    viewWindow: { max: [12]},
                  },
                  vAxis: {
                      title: '{{$kpi->descripcionsyb}}',
                  }
                  
                  
                  
              }
              
            });

            dashboard.bind(donutRangeSlider, pieChart);

            dashboard.draw(data);

            $(window).smartresize(function () {
              dashboard.draw(data, options);
              });
            
        }  

        var collectionhistorico = <?php echo $collectionHistorico; ?>;
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(linechartHistorico);
        

        function linechartHistorico() {
            var data = google.visualization.arrayToDataTable(collectionhistorico);
            var options = {
                
              responsive: true,
                curveType: 'function',
                title: '',
               
                legend: {
                    position: 'right'
                },
                pointSize: 3, 
                hAxis: {
                  title: 'Fecha Medición',
                  
                  viewWindow: { max: [30] },
                },
                vAxis: {
                    title: '{{$kpi->descripcionsyb}}',
                    viewWindow: {'min': 0, 'max': 100},
                }
                
                
                
            };
            var chartH = new google.visualization.LineChart(document.getElementById('lineChartHistorico'));
            chartH.draw(data, options);
           
        }  

/* MENSUAL */
      var collectionMensual = <?php echo $collectionMensual; ?>;
        /* google.charts.load('current', {
            'packages': ['corechart']
        }); */
        google.charts.load('current', {'packages':['corechart', 'controls']});
        google.charts.setOnLoadCallback(drawDashboard);
        

        function drawDashboard() {
             var data = google.visualization.arrayToDataTable(collectionMensual);  
            

            var dashboard = new google.visualization.Dashboard(
            document.getElementById('dashboard_div'));

            var donutRangeSlider = new google.visualization.ControlWrapper({
              'controlType': 'CategoryFilter', /* NumberRangeFilter 'StringFilter',CategoryFilter */
              'containerId': 'filter_div',
              'options': {
                'filterColumnLabel': 'mes'
               }
           });

           var pieChart = new google.visualization.ChartWrapper({
              chartType: 'LineChart',
              containerId: 'chart_div',
               options : {
                selectionMode: 'multiple',
                responsive: true,
                  curveType: 'function',
                  title: '',
                 
                  legend: {
                      position: 'right'
                  },
                  pointSize: 3, 
                  hAxis: {
                    title: 'Mes Medición',
                    viewWindowMode:'explicit',
                    
                  },
                  vAxis: {
                      title: '{{$kpi->descripcionsyb}}',
                      viewWindow: {'min': 0, 'max': 100},
                  },
                  
                  width: 1980,
        
                  
              }
              
            });

            dashboard.bind(donutRangeSlider, pieChart);

            dashboard.draw(data);

            
        }  



</script>



</x-slot>

</x-master-layout>