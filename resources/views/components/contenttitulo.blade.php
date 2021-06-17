    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-3">
            <div class="col-sm-6" >
              <ol class="breadcrumb float-sm-left">
              <li ><h1 class="m-0">{{$slot}} </h1></li>
                <li ><small class="small-box-footer">&nbsp;&nbsp;&nbsp;  {{ $fechaActualizacion }} </small></li> 
              </ol>
              
              
              
            </div><!-- /.col -->
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">{{$slot}}</li>  
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>