
<x-master-layout> 
    <x-slot name="lista"> 
        @foreach ($indicadorkpis as $indicadorkpi)
            <li class="nav-item">
            
            <a href="{{ route('kpi',$indicadorkpi->id) }}"  class="nav-link " >
            
                <i class="far fa-compass nav-icon"></i>
                <p>{{ $indicadorkpi->nombre }} </p>
            </a>
            </li>
        @endforeach
    </x-slot>

    <x-slot name="slot">
        <x-contenttitulo> KPI's
            <x-slot name="fechaActualizacion"> </x-slot>
        </x-contenttitulo>
        <x-crudlist>
            <x-slot name="titulo">{{ 'Lista de KPI' }}</x-slot>
            <x-slot name="subtitulo"></x-slot>
            <x-slot name="NuevoBoton">{{ 'Nuevo KPI' }}</x-slot>
            <x-slot name="UrlNuevoBoton">{{ route('indicadorkpis.create') }}</x-slot>

            <x-slot name="botones"></x-slot>
            <x-slot name="thead">
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Simbolo</th>
                
                
            </x-slot>
            <x-slot name="tbody">
      
            @foreach ($indicadorkpis as $indicadorkpi)
            <tr>
            <x-crudtbody>{{ $indicadorkpi->id }}</x-crudtbody>
            <x-crudtbody>{{ $indicadorkpi->nombre }}</x-crudtbody>
            <x-crudtbody>{{ $indicadorkpi->descripcion }}</x-crudtbody>
            <x-crudtbody>{{ $indicadorkpi->formato }}</x-crudtbody>
            
            
            <x-crudbotones>
                <x-botoneditareliminar> {{ route('indicadorkpis.destroy', $indicadorkpi) }} 
                <x-slot name="urleditar">{{ route('indicadorkpis.edit', $indicadorkpi->id) }}</x-slot>
                </x-botoneditareliminar>
            </x-crudbotones>
    
            </tr>
            @endforeach
      
    </x-slot>
    
    <x-slot name="links">
      {!! $indicadorkpis->links() !!}
    </x-slot>

  </x-crudlist>
    </x-slot>
</x-master-layout>

