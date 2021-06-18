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

<section class="content">

    @if ( ( Auth::user()->getRoleNames()[0] == "Admin") || ( Auth::user()->getRoleNames()[0] == "PorFormatos") )
        <x-contenttitulo> Panel de Indicadores
            <x-slot name="fechaActualizacion"> [ Última Actualización {{ date("d-m-Y", strtotime($ultimoFecha)) }} {{ date("H:i A", strtotime($ultimoHora)) }} ] </x-slot>
        </x-contenttitulo>

        

            <div class="row  ">
                @foreach ($diariokpis as $diariokpi)
                <div class="col-lg-3 col-3 ">


                    <img src="{{ asset('/img/'.$diariokpi->formato.'.png') }}" alt="" class="rounded mx-auto d-block" width="100" height="100" style="opacity: .8">

                </div>
                @endforeach
            </div>

            @foreach ($kpis as $kpi)
            <i class="fas fa-th mr-1"></i>{{ $kpi->nombre }} [ % Locales ]
            <div class="row">
                @foreach ($kpis[0]->datosD as $dato)
                <div class="col-lg-3 col-3">

                    <figure class="highcharts-figure">
                        <div id="container-{{$kpi->id}}-{{$dato->formato}}"></div>
                    </figure>

                </div>
                @endforeach
            </div>
            @endforeach
    @endif

    </section>









            <!-- CHART HIGHCHARTS -->

            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>

            <script type="text/javascript">
                Highcharts.setOptions({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie',
                        scrollablePlotArea: {
                            minWidth: 200,
                            scrollPositionX: 1
                        },
                        spacingBottom: 0,
                        spacingTop: 0,
                        spacingLeft: 0,
                        spacingRight: 0,
                        width: null,
                        height: 100,
                    },
                    title: {
                        text: '',
                        style: {
                            display: 'none'
                        }
                    },
                    subtitle: {
                        text: '',
                        style: {
                            display: 'none'
                        }
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    tooltip: {
                        valueDecimals: 1,
                        valuePrefix: '',
                        valueSuffix: ' %'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: false,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: ' {point.percentage:.1f} %',
                                connectorWidth: 0,
                                connectorPadding: 1,
                                distance: 0,
                            }
                        }
                    },
                    exporting: {
                        enabled: false
                    },

                    credits: {
                        enabled: false // Disable copyright information
                    }


                });
            </script>

            <script type="text/javascript">
                $(function() {

                    // ajax
                    $.get('/formatoall/1/ALV', function(data) {
                        for (var i = 0; i < data.length; ++i) {
                            var idformato = data[i].id + '-' + data[i].formato;
                            //alert('container-' + idformato + ':' + data[i].bajo);
                            var chart1 = new Highcharts.Chart({
                                chart: {
                                    renderTo: 'container-' + idformato,
                                },
                                series: [{
                                    name: 'Locales',
                                    colorByPoint: false,
                                    data: [{
                                        name: 'Critico',
                                        y: data[i].critico,
                                        color: 'red',
                                    }, {
                                        name: 'Medio',
                                        y: data[i].medio,
                                        color: 'yellow',
                                    }, {
                                        name: 'Bajo',
                                        y: data[i].bajo,
                                        color: 'Green',

                                    }] //data
                                }], // serie
                            }); //charts



                        }
                    }); // formatoall          
                }); //function
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



    </x-slot>

</x-master-layout>