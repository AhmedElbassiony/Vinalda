@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ route('itemChildren.index') }}" class="breadcrumb-item">الاصناف</a>
                    <span class="breadcrumb-item active">تفاصيل الصنف</span>
                    <span class="breadcrumb-item active">{{ $itemChildren->item->name ?? null  }}</span>
                    @if ($stock_id==1)
                    <span class="breadcrumb-item active">مخزن المنصورة</span>
                    @else
                    <span class="breadcrumb-item active">مخزن دمياط</span>
                    @endif
                    <span class="breadcrumb-item active">{{ $itemChildren->lot_number ?? 'بدون'  }}</span>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
@if(Session::has('success'))
<div class="alert alert-success border-0 alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <p class="font-weight-semibold">{{ Session::get('success') }}</p>
</div>
@endif
<div class="card">
    <div class="card-header">
        <h5 class="card-title">التفاصيل</h5>
        @if ($stock_id==1)
        <h5 style="font-weight: 500!important" class="card-title">المخزن : مخزن المنصورة   </h5>
        @else
        <h5 style="font-weight: 500!important" class="card-title">المخزن : مخزن دمياط   </h5>
        @endif
       
        
        <h5 style="font-weight: 500!important" class="card-title">أجمالي المشتريات :&nbsp; {{$countPurchase}}</h5>
        <h5 style="font-weight: 500!important" class="card-title">أجمالي المبيعات :&nbsp;&nbsp;&nbsp;&nbsp; {{$countSale}}</h5>
        @if ($stock_id==1)
        <h5  style="font-weight: 500!important" class="card-title">أجمالي المحول الي مخزن المنصورة : {{$countTo}}</h5>
        <h5 style="font-weight: 500!important"  class="card-title">أجمالي المحول من مخزن المنصورة :&nbsp; {{$countFrom}}</h5>
        @else
        <h5 style="font-weight: 500!important" class="card-title">أجمالي المحول الي مخزن دمياط : {{$countTo}}</h5>
        <h5 style="font-weight: 500!important" class="card-title">أجمالي المحول من مخزن دمياط :&nbsp; {{$countFrom}}</h5>
        @endif
        <h5  style="font-weight: 500!important" class="card-title">الكمية المتوفرة :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$count}}</h5>
        
    </div>

    <table class="table datatable-button-init-basic table-bordered text-center">
        <thead>
        <tr>
            <th class="text-center">التسلسل</th>
            <th class="text-center">كود الفاتورة</th>
            <th class="text-center">نوع الفاتورة</th>
             <th class="text-center"> تاريخ الفاتورة</th>
            <th class="text-center"> البيان</th>
            <th class="text-center"> وارد</th>
            <th class="text-center"> منصرف</th>
            <th class="text-center"> الرصيد</th> 
        </tr>
        </thead>
    </table>
</div>
<!-- /state saving -->

@endsection

@section('script')
<script src="{{ asset('backend/global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('backend/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
<script src="{{ asset('backend/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/app.js') }}"></script>
<script src="{{ asset('backend/global_assets/js/demo_pages/form_select2.js') }}"></script>
<script>
    var table = $('.datatable-button-init-basic').DataTable({
        // processing : true,
        // serverSide: true,
        "pageLength": 50,
        ajax: '{{ route('itemChildren.detailsData' , ['itemChildren'=>$itemChildren , 'stock_id'=>$stock_id] )}}',
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: "editBill"},
            {data: "bill_type"},
            {data: "bill_date"},
            {data: "info_name"},
            {data: "count_import"},
            {data: "count_export"},
            {data: "count_after" } ,
        ],
        'columnDefs': [ {
        'targets': [0,1,2,3,4,5,6,7], /* column index */
        'orderable': false, /* true or false */
     }]

       
    });
   
</script>
@endsection


