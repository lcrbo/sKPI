
@props(['subtitulo'=>' ', 'NuevoBoton'=>'', 'UrlNuevoBoton'=>'#'])

<x-alert2 ></x-alert2>

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{ $titulo }} <small>{{$subtitulo}}</small></h3>
              </div>

              <form id="quickForm">
              <div class="card-header">
              
              </div>
                <div class="card-body">
                @if ($NuevoBoton)
                <div class="float-right">
                <a class="btn btn-success" href="{{ $UrlNuevoBoton }}" role="button">{{ $NuevoBoton }}</a>
                </div>
                @endif
                <div class="float-right">
               
                
                {{$botones}}
                </div>

                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          {{ $thead }}
                          
                        </tr>
                      </thead>
                      <tbody >
                         
                        {{ $tbody }}
                        
                      </tbody>
                    </table>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </section>
    {{ $links }}
     




