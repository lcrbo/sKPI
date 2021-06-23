<x-master-layout>
    <x-slot name="stylesheet">
        <!-- CHART HIGHCHARTS -->
        <link rel="stylesheet" href="{{ asset('css/highcharts.css') }}">
        
    </x-slot>

    <x-slot name="slot">

        <x-contenttitulo> Panel de Indicadores
            <x-slot name="fechaActualizacion"> [ Última Actualización {{ date("d-m-Y", strtotime($ultimoFecha)) }} {{ date("H:i A", strtotime($ultimoHora)) }} ] </x-slot>
        </x-contenttitulo>

        <section class="content">

        @if ($user->formato == 'ALL')
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

        @else

        <div class="row  ">
                @foreach ($diariokpis as $diariokpi)
                <div class="col-lg-4 ">

                @if ( $diariokpi->formato == $user->formato)
                    <img src="{{ asset('/img/'.$diariokpi->formato.'.png') }}" alt="" class="rounded mx-auto d-block" width="100" height="100" style="opacity: .8">
                @endif
                </div>
                @endforeach
            </div>

            @foreach ($kpis as $kpi)
            <i class="fas fa-th mr-1"></i>{{ $kpi->nombre }} [ % Locales ]
            <div class="row">
                @foreach ($kpis[0]->datosD as $dato)
                <div class="col-lg-4">
                   
                @if ( $dato->formato == $user->formato)
                
                    <figure class="highcharts-figure" >
                @else
                <figure class="highcharts-figure" style="display:none ">
                @endif
                        <div id="container-{{$kpi->id}}-{{$dato->formato}}"></div>
                    </figure>
                
                </div>
                @endforeach
            </div>
            @endforeach


        @endif 
        </section>
    </x-slot>

    <x-slot name="scriptLocal">

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



            <!-- jQuery -->
            <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
            <!-- Bootstrap 4 -->
            <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <!-- AdminLTE App -->
            <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="{{ asset('dist/js/demo.js') }}"></script>

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


    </x-slot>

</x-master-layout>