{{--<div class="list-icons">--}}
{{--    <a href="{{ route('billSale.edit' , $id) }}"--}}
{{--       class="list-icons-item text-primary-600 pr-2"><i class="icon-pencil7"></i></a>--}}
{{--    <form action="{{ route('billSale.destroy' , $id) }}"--}}
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

<div class="list-icons">
    <div class="dropdown">
        <a href = "#" class="list-icons-item" data-toggle="dropdown">
            <i class="icon-menu9" ></i>
        </a>
        <div class="dropdown-menu">
            <a href = "{{ route('billExchange.edit' , $id) }}" class="dropdown-item" ><i class="icon-pencil7" ></i>تعديل بيانات فاتورة تحويلات</a>
            <a href = "{{ route('billExchange.print' , $id) }}" target="_blank" class="dropdown-item" ><i class="icon-printer" ></i> طباعة فاتورة تحويلات </a>
            <a href = "{{ route('bill.delete' , $id) }}" class="dropdown-item" onclick="return confirm('هل انت متاكد؟');"><i class="icon-trash" ></i> حذف فاتورة تحويلات </a>
            {{--            <a href = "{{ route('bills-sales.show' , $id) }}" class="dropdown-item" ><i class="icon-eye" ></i> عرض بيانات فاتورة مبيعات </a>--}}
            {{--            <a href = "{{ route('bill-sale.print' , $id) }}" class="dropdown-item" ><i class="icon-printer" ></i> طباعة فاتورة مبيعات بالكميات</a>--}}
            {{--            <a href = "{{ route('bill-sale.invoice' , $id) }}" class="dropdown-item" ><i class="icon-printer2" ></i> طباعة فاتورة مبيعات </a>--}}
        </div>
    </div>
</div>
