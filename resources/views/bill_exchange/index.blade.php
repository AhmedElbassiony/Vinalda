@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">فواتير تحويلات</span>
                </div>
                <a href="#" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="{{ route('billExchange.create') }}" class="breadcrumb-elements-item font-weight-bold">
                        <i class="icon-plus2 mr-2"></i>
                        اضافة فاتورة تحويلات جديدة
                    </a>
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

    @if(Session::has('error'))
        <div class="alert alert-danger border-0 alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <p class="font-weight-semibold">{{ Session::get('error') }}</p>
        </div>
    @endif
    <!-- State saving -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">فواتير تحويلات</h5>
        </div>

        <table class="table datatable-button-init-basic table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center">التسلسل</th>
                <th class="text-center">الكود</th>
                <th class="text-center">اسم المخزن المحول منه</th>
                <th class="text-center">اسم المخزن المحول إليه</th>
                <th class="text-center">تاريخ الفاتورة</th>
                <th class="text-center">ملاحظات</th>
                <th class="actions text-center">العمليات</th>
            </tr>
            </thead>
        </table>
    </div>
    <!-- /state saving -->

@endsection

@section('script')
    <script src="{{ asset('backend/global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script>
        var table = $('.datatable-button-init-basic').DataTable({
            // processing : true,
            // serverSide: true,
             "pageLength": 100,
            ajax: '{{ route('billExchange.data') }}',
            columns: [
                {
                    data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: "link"},
                {data: "from_stock"},
                {data: "to_stock"},
                {data: "date"},
                {data: "description"},
                {data: "actions"},
            ],
        });
    </script>
@endsection
