

@props(['reportes'=>'','stylesheet'=>'','scriptLocal'=>''])

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Visualizador KPI </title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('/img/smu_circulo.png') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


  
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

  <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 
  {{ $stylesheet }}
   
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- MENU DERECHA Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <!-- <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a> -->
        <!-- <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div> -->
      </li>
      <!-- Notifications Dropdown Menu -->
     <!--  FULL SCREEN -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     <!--  BARRA DERECHA -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
      <!-- USUARIO -->
      <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} 
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.password', $user->id) }}"
                                       >
                                        {{ __('Cambiar Contraseña') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
    </ul>
    <!-- FIN MENU DERECHA  Right navbar links -->
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="{{ asset('/img/smu_circulo.png') }}" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SMU KPI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">  
          <a href="#" class="d-block">{{ Auth::user()->name }}</a> 
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @if ( ( Auth::user()->getRoleNames()[0] == "Admin") || ( Auth::user()->getRoleNames()[0] == "PorFormatos") )
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
               Listado de KPI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            

              @foreach ($indicadorkpis as $indicadorkpi)
                <li class="nav-item">
                @if ($indicadorkpi->id == $kpi->id)
                <a href="{{ route('kpi',$indicadorkpi->id) }}"  class="nav-link active "  >
                @else
                <a href="{{ route('kpi',$indicadorkpi->id) }}"  class="nav-link "  >
                @endif
                    <i class="far fa-compass nav-icon"></i>
                    <p>{{ $indicadorkpi->nombre }} </p>
                </a>
                </li>
              @endforeach
              
              
            </ul>
           
          </li> 
          @endif
          <!-- reportes -->
          <li class="nav-item">
            <a  class="nav-link"  data-toggle="modal" data-target="#reporte">
              <i class="nav-icon far fa-list-alt"></i>
              <p>Reportes</p>
            </a>
          </li>

         @if ( Auth::user()->getRoleNames()[0] == "Admin") 
          <li class="nav-item">
            <a href="{{ route('indicadorkpis') }}" class="nav-link">
            
              
              <i class="fab fa-airbnb"></i>

              <p>
                Configuración
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>

          </li>
          @endif
          <!-- USAURIOS -->
          @if ( Auth::user()->getRoleNames()[0] == "Admin") 
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
            
              
              <i class="fab fa-airbnb"></i>

              <p>
                Usuarios
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>

          </li>
          @endif
          


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <!-- Main content -->
    {{ $slot }}
  </div>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Configuración</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->



  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <!-- <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>  -->
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021 <a href="https://smu.cl">SMU</a>.</strong> Todos los derechos reservados.
 </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->












<!-- modal -->      
<div class="modal fade" id="reporte">
  <div class="modal-dialog modal-lg">
  <form action="{{ route('reportes') }}" method="GET" id="reporteshow">
    <div class="modal-content">
      <div class="card">
          <div class="card-header border-1">
            <h3 class="card-title">
              <i class="far fa-list-alt"></i>
              Reporte de Locales
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      </div>
      <div class="card">
        <div class="card-header border-0">
              
              <label for="combo" >Seleccionar un KPI</label>
              <!-- select -->
              <div class="form-group">
                        
                        <select name="idkpi" id="idkpi" class="shadow-sm focus:ring-indigo-500 focus:border-red-500 mt-1 block w-full sm:text-sm border-red-300 rounded-md" >
                          <option value="">--- Seleccione  ---</option>
                          @foreach($indicadorkpis as $indicadorkpi)
                            <option value = "{{ $indicadorkpi->id}}" >
                            {{ $indicadorkpi->nombre }} 
                        
                            </option>
                          @endforeach
                        </select>
              </div>
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
                @if ( Auth::user()->getRoleNames()[0] == "PorUnLocal")
                  <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" id="formato{{$user->formato}}" 
                           checked
                            value="{{$user->formato}}">
                          <label class="form-check-label">{{$user->formato}}</label>
                      </div>
                @else
                @if (( $user->formato == 'ALL')  || ( $user->formato == 'ALV') )
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato" id="formatoALV" 
                           <?php if (isset($formato) && $formato=="ALV") echo "checked";?> 
                            value="ALV">
                          <label class="form-check-label">Alvi</label>
                      </div>
                @endif
                @if (( $user->formato == 'ALL')  || ( $user->formato == 'M10') )
                      <div class="form-check">
                        <input  class="form-check-input" type="radio"  name="formato"   id="formatoM10"
                        <?php if (isset($formato) && $formato=="M10") echo "checked";?>
                        value="M10">
                        <label class="form-check-label">Mayorista 10</label>
                      </div>
                 @endif     
                 @if (( $user->formato == 'ALL')  || ( $user->formato == 'OKM') )
                        <div class="form-check">
                          <input  class="form-check-input" type="radio" name="formato"   id="formatoOKM"
                          <?php if (isset($formato) && $formato=="OKM") echo "checked";?>
                          value="OKM"> 
                          <label class="form-check-label">OKMarket</label>
                        </div>
                   @endif
                   @if (( $user->formato == 'ALL')  || ( $user->formato == 'UNI') )     
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="formato"  id="formatoUNI"
                          <?php if (isset($formato) && $formato=="UNI") echo "checked";?>
                          value="UNI"> 
                          <label class="form-check-label">Unimarc</label>
                        </div>
                  @endif
                  @endif     
                        
                </div>
              </div>
            
          </div>
        </div>
        <!-- derecha column -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header border-0">
              
              <label for="combo" >Seleccionar un local</label>
                <div class="form-group">
                
                @if ( Auth::user()->getRoleNames()[0] == "PorUnLocal")  
                      <select name="local" id="localesbyid" class="shadow-sm focus:ring-indigo-500 focus:border-red-500 mt-1 block w-full sm:text-sm border-red-300 rounded-md" >
                          <option value="{{$user->local}}">{{$user->local}}</option>
                          
                        </select>
                @else    
                <x-label>
                    <x-slot name="nombre">Local</x-slot> 
                    <x-slot name="campo">local</x-slot> 
                    <x-slot name="valor">{{old('local',$user->local)}}</x-slot> 
                </x-label>

                   <!--      <select name="local" id="localesbyid" class="shadow-sm focus:ring-indigo-500 focus:border-red-500 mt-1 block w-full sm:text-sm border-red-300 rounded-md" >
                          <option value="">--- Seleccione  ---</option>
                          
                        </select> -->
                @endif
                </div>
            </div>
            <div class="card-body">
                
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar </button>
              <button type="submit" class="btn btn-primary" id="brnsubmit" >
                Generar  
                
              </button>
      </div>

    </div>
  </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--  <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>  -->


  


    
   <script type="text/javascript">

$('#formatoALV').click(clickSelecionFormato );
$('#formatoM10').click(clickSelecionFormato );
$('#formatoOKM').click(clickSelecionFormato );
$('#formatoUNI').click(clickSelecionFormato );

function clickSelecionFormato() {

  var formato_id = $(this).val(); 
 
  var cod = document.getElementById("idkpi").value;


  // ajax
  $.get('/localesbyid/'+cod+'/'+formato_id, function(data) {
    var html_select = '<option value="">--- Seleccione  ---</option>';
    for (var i=0; i <data.length; ++i)
      html_select += '<option value = "'+data[i].local+'"> '+data[i].local+' </option>'
      
     $('#localesbyid').html(html_select);
  });
}

 $('#brnsubmit').click(function() {
    setTimeout(function() {$('#reporte').modal('hide');}, 4000);
});




</script>
   
{{ $scriptLocal}}

</body>
</html>
