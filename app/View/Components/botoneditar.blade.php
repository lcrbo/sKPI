@props(['color'=>'blue', 'url'=>'', 'tag'=>'Editar'])

<!-- <button class="ml-1 inline-flex justify-center py-1 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-{{$color}}-600 hover:bg-{{$color}}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
<a href="{{ $slot }}" class="btn btn-success">{{ $tag }}</a> -->

<a class="btn btn-primary" href="{{ $slot }}" role="button">Editar</a>

