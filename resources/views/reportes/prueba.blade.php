
<!DOCTYPE html>
<html>
<head>

  <title>Visualizador KPI </title>
  
  <!-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> -->



  <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<!-- CHART HIGHCHARTS -->
  <!-- <link rel="stylesheet" href="{{ asset('css/highcharts.css') }}"> -->


   
</head>
<body>
    <h1>{{ $kpi->nombre }}</h1>
    <p>{{ $kpi->nombre }}</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

    <div >
                
                <figure class="highcharts-figure">
                  <div id="containerD"></div>
                </figure>
                 
              
            </div>
</body>


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




let chart = Highcharts.chart('containerD', {
  chart: {
        type: 'spline',
        scrollablePlotArea: {
            minWidth: 400,
            scrollPositionX: 1
        }
    },
    title: {
        text: '{{$kpi->nombre}} por mes'
    },
    subtitle: {
        text: '({{$kpi->descripcionsyb}}  x  hora medición )'
    },
    xAxis: {
        type: 'datetime',
        labels: {
            overflow: 'justify'
        },
        title: {
            text: 'Hora medición',
            style:{
                color:'black'
            }
        },
        categories: categoriasD
    },
    yAxis: {
        tickWidth: 1,
        lineWidth: 1,
        
        title: {
            text: ' {{$kpi->descripcionsyb}}',
            style:{
                color:'black'
            }
            
        },
        max:100,
    },
    tooltip: {
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


var fontStyle = document.createElement('style');

fontStyle.appendChild(document.createTextNode("\
@font-face {\
font-family: 'Pacifico';\
font-style: normal;\
font-weight: 400;\
src: local('Pacifico Regular'), local('Pacifico-Regular'), url(https://fonts.gstatic.com/s/pacifico/v13/FwZY7-Qmy14u9lezJ-6H6Mk.woff2) format('woff2');\
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;\
            }\
            "));

document.head.appendChild(fontStyle);


</script>
</html>