@if($bill_status == 1)
{{--    @if(auth()->user()->can('edit bill status'))--}}
        <td>
            <form action="{{ route('bill.update.status' , $id) }}"
                  method="post">
                @csrf
                @method('PATCH')
                <input type="checkbox" data-color="primary" name="status"
                       onchange="this.form.submit()"  {{ $bill_status ? 'checked' : '' }}  onclick="return confirm('هل انت متاكد؟');">
            </form>
        </td>
{{--    @else--}}
{{--        <td>--}}
{{--            <span class="badge badge-flat border-dark text-dark ml-2">مغلق</span>--}}
{{--        </td>--}}
{{--    @endif--}}
@else
    <td>
        <form action="{{ route('bill.update.status' , $id) }}"
              method="post">
            @csrf
            @method('PATCH')
            <input type="checkbox" data-color="primary" name="status"
                   onchange="this.form.submit()" {{ $bill_status == 1 ? 'checked' : '' }}   onclick="return confirm('هل انت متاكد؟');">
        </form>
    </td>
@endif
