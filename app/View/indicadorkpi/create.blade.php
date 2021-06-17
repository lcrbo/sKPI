<x-master-layout>
<x-slot name="lista"> 
        @foreach ($indicadorkpis as $indicador)
            <li class="nav-item">
            <a href="{{ route('kpi',$indicador->id) }}" class="nav-link active">
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
            <x-slot name="titulo">Incorporar nuevo KPI</x-slot>
            <x-slot name="subtitulo"></x-slot>
            <x-slot name="action">{{route('indicadorkpis.store')}}</x-slot> 

            <x-slot name="campos">
                
                <x-label>
                    <x-slot name="nombre">Nombre</x-slot> 
                    <x-slot name="campo">nombre</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->nombre}}</x-slot> 
                </x-label>
                <x-label>
                    <x-slot name="nombre">Descripción</x-slot> 
                    <x-slot name="campo">descripcion</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->descripcion}}</x-slot> 
                </x-label>
                <x-label>
                    <x-slot name="nombre">Simbolo</x-slot> 
                    <x-slot name="campo">formato</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->formato}}</x-slot> 
                </x-label>
                <a >La mayor&#237;a de los indicadores clave de rendimiento tienen un formato o un s&#237;mbolo, como la moneda, porcentaje o tiempo. El formato que elija se mostrar&#225; en el sistema"
                </a>
                <x-label>
                    <x-slot name="nombre">Descripción Simbolo</x-slot> 
                    <x-slot name="campo">descripcionsyb</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->descripcionsyb}}</x-slot> 
                </x-label>
                <x-label>
                    <x-slot name="nombre">Cantidad de días máximo de visualización</x-slot> 
                    <x-slot name="campo">diasmax</x-slot> 
                    <x-slot name="valor">{{$indicadorkpi->diasmax}}</x-slot> 
                </x-label>
                <div>
                    <label for="Umbrales" class="block text-sm font-medium text-gray-700">Umbrales</label>
                    <a>Introduzca el rojo, amarillo y verde umbrales para resaltar los valores reales a trav&#233;s de la aplicaci&#243;n.</a>
    
                    <img src="{{ asset('/img/rag_values.png') }}" style="clear:both;display:block;margin:0 0 3px 34px" />
                           
                    <div class="form-inline">
                        <input type="umbral1" name="umbral1" class="form-control" id="umbral1" placeholder="" value="{{old('umbral1',$indicadorkpi->umbral1)}}" style="width:70px;margin-right:35px;text-align:right"  tabindex="20" type="text">
                        <input type="umbral2" name="umbral2" class="form-control" id="umbral2" placeholder="" value="{{old('umbral2',$indicadorkpi->umbral2)}}" style="width:70px;margin-right:35px;text-align:right"  tabindex="21" type="text">
                    
                            <input type="umbral3" name="umbral3" class="form-control" id="umbral3" placeholder="" value="{{old('umbral3',$indicadorkpi->umbral3)}}" style="width:70px;margin-right:40px;text-align:right" tabindex="22" type="text">
                        <input type="umbral4" name="umbral4" class="form-control" id="umbral4" placeholder="" value="{{old('umbral4',$indicadorkpi->umbral4)}}" style="width:70px;margin-right:20px;text-align:right" tabindex="23" type="text">
                        
                    </div>

                </div>

            </x-slot>
            
                
            
            <x-slot name="botones">
                <x-botonsubmit>Actualizar</x-botonsubmit>
                <x-botonvolver>{{ route('indicadorkpis.index')}}</x-botonvolver>
            </x-slot>
        </x-crudform>
    </x-slot>
</x-master-layout>

