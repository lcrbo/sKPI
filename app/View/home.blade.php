<x-master-layout> 
    <x-slot name="lista"> 
        @foreach ($indicadorkpis as $indicadorkpi)
            <li class="nav-item">
            <a href="{{ route('kpi',$indicadorkpi->id) }}" class="nav-link ">
                <i class="far fa-compass nav-icon"></i>
                <p>{{ $indicadorkpi->nombre }}  </p>
            </a>
            </li>
        @endforeach

        </x-slot>

<x-slot name="slot">





</x-slot>

</x-master-layout>

