<div>
<div class="btn-group" role="group" aria-label="...">
    <div class="form-group">
        <label for="combo" class="block text-sm font-medium text-gray-700">
            {{$nombre}}
        </label>
        <select name="{{$campo}}" class="shadow-sm focus:ring-indigo-500 focus:border-red-500 mt-1 block w-full sm:text-sm border-red-300 rounded-md" >
        <option value="">--- Seleccione  ---</option>
            {{$condicion}}
        </select>

    </div>
    @error($campo)
        <small class="text-red-500">* {{$message}}.</small>
    @enderror
</div>
</div>