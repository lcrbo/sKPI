

<form action="{{$slot}}" method="POST">
        @csrf
        @method('delete')
        <!-- <button type="submit" onclick="return confirm('Estas seguro de eliminar ')" class="ml-1 inline-flex justify-center py-1 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <a  class="btn btn-success">Eliminar</a>
        </button> -->

        <button type="submit" onclick="return confirm('Estas seguro de eliminar ')" class="btn btn-danger">Eliminar</button>
        
</form>