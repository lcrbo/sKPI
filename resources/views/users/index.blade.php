<x-master-layout> 


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



</x-slot>
</x-master-layout>