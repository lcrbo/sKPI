@props(['color'=>'text-gray-900', 'bcolor'=>''])

<td >
    
    <div class="text-sm {{$color}} {{$bcolor}}" > {{ $slot }}</div>
</td>