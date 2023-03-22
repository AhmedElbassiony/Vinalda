{{--<div class="list-icons">--}}
{{--    <a href="{{ route('billPurchase.edit' , $id) }}"--}}
{{--       class="list-icons-item text-primary-600 pr-2"><i class="icon-pencil7"></i></a>--}}
{{--    <form action="{{ route('billPurchase.destroy' , $id) }}"--}}
{{--          method="post">--}}
{{--        @csrf--}}
{{--        @method('DELETE')--}}
{{--        <button type="submit" class="btn list-icons-item text-danger-600"--}}
{{--                style="padding: 0;background: transparent; color: red"--}}
{{--                onclick="return confirm('هل انت متاكد؟');">--}}
{{--            <i class="icon-trash"></i>--}}
{{--        </button>--}}
{{--    </form>--}}
{{--</div>--}}

@if ($bill_type=='مشتريات')
<a href = "{{ route('billPurchase.edit' , $bill_id) }}"  >{{$code}}</a>

@elseif ($bill_type=='مبيعات')
<a href = "{{ route('billSale.edit' , $bill_id) }}"  >{{$code}}</a>
@else
<a href = "{{ route('billExchange.edit' , $bill_id) }}"  >{{$code}}</a>
@endif





