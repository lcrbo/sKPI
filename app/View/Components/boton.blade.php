@props(['color'=>'blue', 'url'=>''])

<button class="ml-1 inline-flex justify-center py-1 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-{{$color}}-600 hover:bg-{{$color}}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
<a href="{{ $url }}" class="btn btn-success">{{ $slot }}</a>

<!-- <a role="button"  href="" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2  border rounded-full">
             nombreboton          
    </a> -->