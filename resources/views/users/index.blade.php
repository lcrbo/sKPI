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
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li>
                <h1 class="m-0">Usuarios </h1>
              </li>
              <li><small class="small-box-footer">&nbsp;&nbsp;&nbsp; </small></li>
            </ol>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Usuarios </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


<div class="row">
    <div class="col-lg-12 margin-tb">
        
        <div class="pull-right">
            <a class="btn btn-success btn-sm" href="{{ route('users.create') }}">
            <i class="far fa-plus-square"></i> Agregar</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
  
   <th>Nombre</th>
   <th>Correo</th>
   <th>Rol</th>
   <th width="280px"></th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @csrf
            @method('delete')
            <a class="btn btn-info btn-sm" href="{{ route('users.edit',$user->id) }}" role="button">
                <i class="fas fa-pencil-alt"></i>
                Editar
            </a>
            <button type="submit" onclick="return confirm('Estas seguro de eliminar ')" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i>
                Eliminar
            </button>
        </form>

     
      
       
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}

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