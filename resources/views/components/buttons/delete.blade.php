<form action="{{$route}}" method="POST">
    @csrf 
    @method("DELETE")
    <button type="submit" class="me-2">
        {{__('Delete')}}
    </button>
</form>
