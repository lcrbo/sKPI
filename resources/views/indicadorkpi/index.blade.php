<x-master-layout>
  <x-slot name="lista">
    @foreach ($indicadorkpis as $indicadorkpi)
    <li class="nav-item">

      <a href="{{ route('kpi',$indicadorkpi->id) }}" class="nav-link ">

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
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li>
                <h1 class="m-0">Lista de KPI </h1>
              </li>
              <li><small class="small-box-footer">&nbsp;&nbsp;&nbsp; </small></li>
            </ol>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Lista de KPI </li>
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
                <h3 class="card-title">Indicadores</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="float-right">


                  <form action="{{ route('indicadorkpis.index') }}" method="GET" class="navbar-form navbar-left" role="search">

                    <div class="input-group small">
                      <input name="nombre" type="text" class="form-control input-sm" placeholder="busqueda">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default btn-sm">
                          <i class="fa fa-search"></i>
                        </button>
                      </div>
                      <a>&nbsp;&nbsp;&nbsp;</a>
                      <a class="btn btn-success btn-sm" href="{{ route('indicadorkpis.create') }}" role="button">
                        <i class="far fa-plus-square"></i>
                        Agregar
                      </a>
                    </div>

                  </form>
                  <a>&nbsp;&nbsp;&nbsp;</a>

                </div>
                <table id="mensualcontrolxxx" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Indicador</th>
                      <th style="width: 20%">
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($indicadorkpis as $indicadorkpi)
                    <tr>
                      @if ( $indicadorkpis != null )
                      <td>

                        <p class="text-black-300 font-bold">
                          <a class="text-blue-500 font-bold">
                            [{{ $indicadorkpi->id }}] </a>
                          {{ $indicadorkpi->nombre }}
                          <a class="text-blue-300 font-bold">
                            [{{ $indicadorkpi->formato }}]</a>
                        </p>
                        <a>
                          {{ $indicadorkpi->descripcion }}
                        </a>
                      </td>
                      <td class="project-actions text-right">

                        <form action="{{ route('indicadorkpis.destroy', $indicadorkpi) }}" method="POST">
                          @csrf
                          @method('delete')
                          <a class="btn btn-info btn-sm" href="{{ route('indicadorkpis.edit', $indicadorkpi->id) }}" role="button">
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
          {!! $indicadorkpis->appends(request()->all())->links('pagination') !!}

          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->



    </section>
    <!-- /.content -->



  </x-slot>
</x-master-layout>