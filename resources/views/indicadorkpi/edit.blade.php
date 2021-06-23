<x-master-layout>
<x-slot name="lista"> 
        @foreach ($indicadorkpis as $indicador)
            <li class="nav-item">
            <a href="{{ route('kpi',$indicadorkpi->id) }}" class="nav-link active">
            <i class="far fa-compass nav-icon"></i>
                <p>{{ $indicador->nombre }}</p>
            </a>
            </li>
        @endforeach
    </x-slot>

    <x-slot name="slot">
        <x-contenttitulo> KPI's
            <x-slot name="fechaActualizacion"> </x-slot>
        </x-contenttitulo>
        <x-crudform>
            <x-slot name="titulo">Actualizar KPI</x-slot>
            <x-slot name="subtitulo"></x-slot>

            <x-slot name="action">{{ route('indicadorkpis.update', $indicadorkpi->id) }}</x-slot> 
             <x-slot name="metodo">@method('PATCH') </x-slot>

            <x-slot name="campos">

                <x-label>
                    <x-slot name="nombre">Nombre</x-slot> 
                    <x-slot name="campo">nombre</x-slot> 
                    <x-slot name="valor">{{old('nombre',$indicadorkpi->nombre)}}</x-slot> 
                </x-label>
                <x-label>
                    <x-slot name="nombre">Descripción</x-slot> 
                    <x-slot name="campo">descripcion</x-slot> 
                    <x-slot name="valor">{{old('descripcion',$indicadorkpi->descripcion)}}</x-slot> 
                </x-label>
                <x-label>
                    <x-slot name="nombre">Símbolo</x-slot> 
                    <x-slot name="campo">formato</x-slot> 
                    <x-slot name="valor">{{old('formato',$indicadorkpi->formato)}}</x-slot> 
                </x-label>
                <a >La mayor&#237;a de los indicadores clave de rendimiento tienen un formato o un s&#237;mbolo, como la moneda, porcentaje o tiempo. El formato que elija se mostrar&#225; en el sistema"
                </a>
                <x-label>
                    <x-slot name="nombre">Descripción Símbolo</x-slot> 
                    <x-slot name="campo">descripcionsyb</x-slot> 
                    <x-slot name="valor">{{old('descripcionsyb',$indicadorkpi->descripcionsyb)}}</x-slot> 
                </x-label>    
                <x-label>
                    <x-slot name="nombre">Cantidad de horas máximo de visualización</x-slot> 
                    <x-slot name="campo">horasmax</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->horasmax}}</x-slot> 
                </x-label>     
                <x-label>
                    <x-slot name="nombre">Cantidad de días máximo de visualización</x-slot> 
                    <x-slot name="campo">diasmax</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->diasmax}}</x-slot> 
                </x-label>
                <x-label>
                    <x-slot name="nombre">Cantidad de meses máximo de visualización</x-slot> 
                    <x-slot name="campo">mesesmax</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->mesesmax}}</x-slot> 
                </x-label>

                <x-label>
                    <x-slot name="nombre">Mensaje cuando no hay información</x-slot> 
                    <x-slot name="campo">errorsindata</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->errorsindata}}</x-slot> 
                </x-label>

               <div>
                    <label for="Umbrales" class="block text-sm font-medium text-gray-700">Umbrales</label>
                    <a>Introduzca el rojo, amarillo y verde umbrales para resaltar los valores reales a trav&#233;s de la aplicaci&#243;n.</a>
    
                    <img src="{{ asset('/img/rag_values.png') }}" style="clear:both;display:block;margin:0 0 3px 34px" />
                           
                    <div class="form-inline">
                        <input type="umbral1" name="umbral1" class="form-control" id="umbral1" placeholder="" value="{{old('umbral1',$indicadorkpi->umbral1)}}" style="width:70px;margin-right:35px;text-align:right"  tabindex="20" type="text" onchange="return validanumero(this)">
                        <input type="umbral2" name="umbral2" class="form-control" id="umbral2" placeholder="" value="{{old('umbral2',$indicadorkpi->umbral2)}}" style="width:70px;margin-right:35px;text-align:right"  tabindex="21" type="text">
                    
                            <input type="umbral3" name="umbral3" class="form-control" id="umbral3" placeholder="" value="{{old('umbral3',$indicadorkpi->umbral3)}}" style="width:70px;margin-right:40px;text-align:right" tabindex="22" type="text">
                        <input type="umbral4" name="umbral4" class="form-control" id="umbral4" placeholder="" value="{{old('umbral4',$indicadorkpi->umbral4)}}" style="width:70px;margin-right:20px;text-align:right" tabindex="23" type="text">
                        
                    </div>

                </div>



            </x-slot>
            
                
            
            <x-slot name="botones">
                <x-botonsubmit>Actualizar</x-botonsubmit>
                <a class="btn btn-success" href="{{ route('indicadorkpis.index')}}" role="button">Volver</a>
            </x-slot>
        </x-crudform>
    </x-slot>


<script type='text/javascript'>

var u1 = document.getElementById("umbral1");

$(document).ready(function() {
  $("#umbral1").validate({
   
    alert("Error: La dirección de correo " + correo + " es incorrecta.");

  });
});

</script>

</x-master-layout>

