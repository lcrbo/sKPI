@props(['subtitulo'=>' ','metodo'=>''])

<x-alert2 ></x-alert2>

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
                
                
            </div>
        </div>
      </div>
      
    <div class="mt-5 md:mt-0 md:col-span-2">
       
      <form action="{{ $action }}" method="POST">
        @csrf

        {{$metodo}} 

        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            {{$campos}}
          
          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">

            {{$botones}}
            
          </div>
          
        </div>
      </form>
    </div>
  </div>
</div>