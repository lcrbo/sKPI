<x-master-layout>

  <x-slot name="stylesheet">

  </x-slot>

  <x-slot name="slot">

    <x-contenttitulo> Usuarios
      <x-slot name="fechaActualizacion"> </x-slot>
    </x-contenttitulo>





    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Atención!</strong> Hay errores de validación.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Actualizar Usuario <small></small></h3>
              </div>


            </div>
          </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">


          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <strong>Nombre</strong>
                  {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <strong>Correo</strong>
                  {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <strong>Password:</strong>
                  {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <strong>Confirmar Password:</strong>
                  {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <strong>Rol</strong>
                  {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <strong>Formato</strong>
                  {!! Form::text('formato', null, array('placeholder' => 'formato','class' => 'form-control')) !!}
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <strong>Local</strong>
                  {!! Form::text('local', null, array('placeholder' => 'local','class' => 'form-control')) !!}
                </div>
              </div>



            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">

              <x-botonsubmit>Actualizar</x-botonsubmit>
              <a class="btn btn-success" href="{{ route('users.index')}}" role="button">Volver</a>

            </div>

          </div>

        </div>

      </div>
      </div>
      {!! Form::close() !!}


    </section>





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