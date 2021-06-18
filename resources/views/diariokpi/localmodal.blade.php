    

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
              <li ><h1 class="m-0">{{$kpi->nombre}}  </h1></li>
                <li ><small class="small-box-footer">&nbsp;&nbsp;&nbsp;  [ Última Actualización {{ date("d-m-Y", strtotime($ultimoFecha)) }}  {{ date("H:i A", strtotime($ultimoHora)) }} ] </small></li> 
              </ol>
           </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">{{$kpi->nombre}} </li>  
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
                <h4 class="card-title">Detalle por hora : {{$locales[0]->formato}}, local {{$locales[0]->local}}</h4>
                <div class="float-right">
                  <a class="btn btn-success btn-sm" href="{{ URL::previous() }}" role="button">
                    <i class="fas fa-arrow-left"></i>
                    Volver
                  </a>
              </div>
              </div>
              
              <!-- /.card-header -->
              

              <div class="card">
              <div class="card-header border-1">
              
                <div class="card-tools">
                  <a class="btn btn-secondary btn-sm"  role="button" id="exportpdf">
                    <i class="far fa-file-pdf"></i>
                    Reporte PDF
                  </a>
                  <a class="btn btn-secondary btn-sm" href="{{ route('exportExcel', [ 'kpiid'=>$kpi->id , 'formato'=>$locales[0]->formato , 'local' => $locales[0]->local, 'archivoExcel' => $kpi->nombre. ' por hora '. $locales[0]->formato .' '. $locales[0]->local .' ' . date('d-m-Y')  ]) }}" role="button">
                  <i class="far fa-file-excel"></i>
                    Exportar Excel
                  </a>
                  <!-- <a class="btn btn-secondary btn-sm" role="button" id="daterange-btn"> 
                  <i class="far fa-calendar-alt"></i>
                    Rango horas
                  </a> -->
                  <button type="button" class="btn bg-info btn-sm"  id="changeColumn">
                  <i class="fas fa-chart-bar"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm"  id="changeSpLine">
                  <i class="fas fa-chart-line"></i>
                  </button>
                  <!-- <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button> -->
                  
                </div>
              </div>
              <div class="card-body">
                
                  <figure class="highcharts-figure">
                    <div id="container"></div>
                  </figure>
                   
                
              </div>
            </div>



                <table id="example1xx" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Hora</th>
  
                    <th>KPI</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($locales as $locale)
                    <tr>
                    @if ( $locale->valor   < $kpi->umbral2 )
                        <td>{{ $locale->hora }}</td>
                        
                        <td>
                          <span class=" bg-danger">{{ $locale->valor }} {{ $kpi->formato }}</span>
                           <div class="progress progress-xs" style="height:5px">
                            <div class="progress-bar bg-danger" style="width: {{ $locale->valor }}{{ $kpi->formato }}"></div>
                          </div>
                          </td>
                        
                    @elseif (( $locale->valor  >= $kpi->umbral2) && ( $locale->valor   < $kpi->umbral3))
                        <td>{{ $locale->hora }}</td>
                        
                        <td>
                            <span class=" bg-warning">{{ $locale->valor }} {{ $kpi->formato }}</span>
                            <div class="progress progress-xs" style="height:5px">
                            <div class="progress-bar bg-warning" style="width: {{ $locale->valor }}{{ $kpi->formato }}"></div>
                          </div>
                        </td>
                      @elseif ( $locale ->valor  >= $kpi->umbral3)
                      <td>{{ $locale->hora }}</td>
                        
                      
                        <td>
                            <span class=" bg-success">{{ $locale->valor }} {{ $kpi->formato }}</span>
                            <div class="progress progress-xs" style="height:5px">
                            <div class="progress-bar bg-success" style="width: {{ $locale->valor }}{{ $kpi->formato }}"></div>
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
          {!! $locales->appends(request()->all())->links('pagination') !!}
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

     

    </section>
    <!-- /.content -->

    

  

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
<!-- CHART HIGHCHARTS -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>





<script type="text/javascript">

/* DIARIO */
var categoriasD =  <?php echo json_encode($fechasD) ?>;
var alvD =  <?php echo json_encode($alvD)  ?>;

Highcharts.getSVG = function(charts) {
  var svgArr = [],
    top = 0,
    width = 0;

  Highcharts.each(charts, function(chart) {
    var svg = chart.getSVG(),
      // Get width/height of SVG for export
      svgWidth = +svg.match(
        /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
      )[1],
      svgHeight = +svg.match(
        /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
      )[1];

    svg = svg.replace(
      '<svg',
      '<g transform="translate('+width+', 0 )" '
    );
    svg = svg.replace('</svg>', '</g>');

    width += svgWidth;
		top = Math.max(top, svgHeight);
	
    svgArr.push(svg);
  });

  return '<svg height="' + top + '" width="' + width +
    '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
    svgArr.join('') + '</svg>';
};

Highcharts.exportCharts = function(charts, options) {

    // Merge the options
    options = Highcharts.merge(Highcharts.getOptions().exporting, options);

    // Post to export server
    Highcharts.post(options.url, {
      filename: options.filename || '{{$kpi->nombre}} por hora de hoy {{ date("d-m-Y") }}',
      type: options.type,
      width: options.width,
      svg: Highcharts.getSVG(charts)
    });
};

let chart = Highcharts.chart('container', {
  chart: {
        type: 'spline',

       
        scrollablePlotArea: {
            minWidth: 400,
            scrollPositionX: 1
        }
    },
    title: {
        text: '{{$kpi->nombre}} por hora de hoy {{ date("d-m-Y") }}'
    },
    subtitle: {
        text: '({{$kpi->descripcionsyb}}  x  hora medición )'
    },
    xAxis: {
        type: 'datetime',
        labels: {
            overflow: 'justify',
            formatter: function() {
                return this.value.substring(5,0) ;
              }
        },
        title: {
            text: 'Hora medición',
            style:{
                color:'black'
            }
        },
        categories: categoriasD,
        
    },
    yAxis: {
        tickWidth: 1,
        lineWidth: 1,
        
        title: {
            text: ' {{$kpi->descripcionsyb}} , ',
            style:{
                color:'black'
            }
            
        },
        max:100,
    },
    tooltip: {
        valueDecimals: 2,
        valueSuffix: ' {{$kpi->formato}}',
        split: false
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
                enabled: true
            },
           
              dataLabels: {
                
                enabled: true,
                format: '{y} {{$kpi->formato}}'
              }
                        
        },
        
    },
    series: [{
      dataLabels: {
                enabled: true
            },
        name: '{{$locales[0]->formato}}, local {{$locales[0]->local}}',
        label: { enabled: false, },
        shadow: false,
        color : '{{$color}}' ,
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
        enabled: false
      },

      credits:{
          enabled: false // Disable copyright information
    }

});

  document.getElementById("changeColumn").addEventListener("click", function() {
    chart.series[0].update({
      type: 'column'
    });
  });
  document.getElementById("changeSpLine").addEventListener("click", function() {
    chart.series[0].update({
      type: 'spline'
    });
  });

  document.getElementById("exportpdf").addEventListener("click", function() {
  Highcharts.exportCharts([chart], {
    type: 'application/pdf'
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

    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date picker
      $('#reservationdate').datetimepicker({
          format: 'L'
      });

      //Date and time picker
      $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

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
        endDate  : moment(),
        datepicker: false,
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'HH:mm'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          language: 'es',
          ranges   : {
            'Hoy'       : [moment(), moment()],
            'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 Días' : [moment().subtract(6, 'days'), moment()],
            'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
            'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
            'Último Mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment(),
          timePicker: true,
          datePicker: false,
        },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()

      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()

      $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
      })

      $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      })

    })
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function () {
      window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })

    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)

    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
      url: "/target-url", // Set the url
      thumbnailWidth: 80,
      thumbnailHeight: 80,
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: "#previews", // Define the container to display the previews
      clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    })

    myDropzone.on("addedfile", function(file) {
      // Hookup the start button
      file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
    })

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
      document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    })

    myDropzone.on("sending", function(file) {
      // Show the total progress bar when upload starts
      document.querySelector("#total-progress").style.opacity = "1"
      // And disable the start button
      file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    })

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
      document.querySelector("#total-progress").style.opacity = "0"
    })

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
      myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#actions .cancel").onclick = function() {
      myDropzone.removeAllFiles(true)
    }
    // DropzoneJS Demo Code End
  </script>


    </x-slot> 
</x-master-layout>
