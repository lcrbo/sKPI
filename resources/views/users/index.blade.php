<x-master-layout> 

<x-slot name="stylesheet">



</x-slot>



<x-slot name="slot">

<x-contenttitulo> Usuarios
  <x-slot name="fechaActualizacion"> </x-slot>
</x-contenttitulo>




@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Usuarios</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="float-right">


                  
                    <div class="input-group small">
                      
                      <a>&nbsp;&nbsp;&nbsp;</a>
                      <a class="btn btn-success btn-sm" href="{{ route('users.create') }}" role="button">
                        <i class="far fa-plus-square"></i>
                        Agregar
                      </a>
                    </div>

                 
                  <a>&nbsp;&nbsp;&nbsp;</a>

                </div>
                <table id="mensualcontrolxxx" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Usuario [nombre - correo - rol]</th>
                      <th style="width: 20%">
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $key => $user)
                    <tr>
                      @if ( $data != null )
                      <td>

                        <p class="text-black-300 font-bold">
                          <a class="text-blue-500 font-bold">
                          {{ $user->name }} </a>
                          {{ $user->email }}
                          <a class="text-blue-300 font-bold">
                          @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                            [{{ $v}}]
                              
                            @endforeach
                          @endif
                            </a>
                        </p>
                        
                      </td>
                      <td class="project-actions text-right">

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
          {!! $data->render() !!}

          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->



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