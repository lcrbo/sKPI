
@if ($message = Session::get('success'))
<div>
    <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-100 bg-green-500 border border-green-500 ">
        <div class="text-xl font-normal  max-w-full flex-initial">
            <div class="py-2">{{ $message }}
                <div class="text-sm font-base"> {{$slot}}</div> 
            </div>
        </div>
    </div>   
</div>
@endif 
@if ($message = Session::get('danger'))
<div>
    <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-100 bg-green-500 border border-green-500 ">
        <div class="text-xl font-normal  max-w-full flex-initial">
            <div class="py-2">{{ $message }}
                <div class="text-sm font-base"> {{$slot}}</div> 
            </div>
        </div>
    </div>   
</div>
@endif 
@if ($message = Session::get('warning'))
<div>
    <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-100 bg-green-500 border border-green-500 ">
        <div class="text-xl font-normal  max-w-full flex-initial">
            <div class="py-2">{{ $message }}
                <div class="text-sm font-base"> {{$slot}}</div> 
            </div>
        </div>
    </div>   
</div>
@endif 
@if ($message = Session::get('info'))
<div>
    <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-100 bg-green-500 border border-green-500 ">
        <div class="text-xl font-normal  max-w-full flex-initial">
            <div class="py-2">{{ $message }}
                <div class="text-sm font-base"> {{$slot}}</div> 
            </div>
        </div>
    </div>   
</div>
@endif 
@if ($errors->any())
<div>
    <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-100 bg-red-500 border border-red-500 ">
        <div class="text-xl font-normal  max-w-full flex-initial">
            <div class="py-2">Hay errores de validadción
            <div class="text-sm font-base"> {{$slot}}
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach  
             </div> 
            </div>
        </div>
    </div>   
</div>
@endif
