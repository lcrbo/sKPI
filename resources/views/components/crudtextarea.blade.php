<div>
    <label for="{{$campo}}" class="block text-sm font-medium text-gray-700">
    {{$nombre}}
    </label>
    <div class="mt-1">
        
    <textarea id="{{$campo}}" name="{{$campo}}" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-red-500 mt-1 block w-full sm:text-sm border-red-300 rounded-md" 
        placeholder="">{{$valor}}</textarea>
    </div>
    @error($campo)
        <small class="text-red-500">* {{$message}}.</small>
    @enderror
</div>