<div class="list-icons">
    <a href="{{ route('itemChildren.edit' , $id) }}"
       class="list-icons-item text-primary-600 pr-2"><i class="icon-pencil7"></i></a>
       <a href="{{ route('itemChildren.details' , ['itemChildren'=>$id , 'stock_id'=>$stock_id ] ) }}"
       class="list-icons-item text-black pr-2"><i class="icon-eye"></i></a>
{{--    <form action="{{ route('itemChildren.destroy' , $id) }}"--}}
{{--          method="post">--}}
{{--        @csrf--}}
{{--        @method('DELETE')--}}
{{--        <button type="submit" class="btn list-icons-item text-danger-600"--}}
{{--                style="padding: 0;background: transparent; color: red"--}}
{{--                onclick="return confirm('هل انت متاكد؟');">--}}
{{--            <i class="icon-trash"></i>--}}
{{--        </button>--}}
{{--    </form>--}}
</div>
