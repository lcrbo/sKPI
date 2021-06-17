<x-master-layout> 
    <x-slot name="lista"> 
    @foreach ($indicadorkpis as $indicadorkpi)
            <li class="nav-item">
            @if ($indicadorkpi->id == $kpi->id)
            <a href="{{ route('kpi',$indicadorkpi->id) }}"  class="nav-link active" >
            @else
            <a href="{{ route('kpi',$indicadorkpi->id) }}"  class="nav-link " >
            @endif
                <i class="far fa-compass nav-icon"></i>
                <p>{{ $indicadorkpi->nombre }} </p>
            </a>
            </li>
        @endforeach

        </x-slot>

<x-slot name="slot">

<div class="alert alert-danger" role="alert">
    NO existe informacion para el KPI {{ $kpi->nombre}}
</div>
</x-slot>

</x-master-layout>