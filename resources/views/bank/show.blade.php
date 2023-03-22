@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ route('bank.index') }}" class="breadcrumb-item">البنوك</a>
                    <span class="breadcrumb-item active">البنك</span>
                    <span class="breadcrumb-item active">{{ $bank->name  }}</span>
                </div>
                <a href="#" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
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
    <!-- State saving -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">العمليات</h5>
        </div>

        <table class="table datatable-button-init-basic table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center">التسلسل</th>
                <th class="text-center">نوع العملية</th>
                <th class="text-center">وصف العملية</th>
                <th class="text-center">تاريخ العملية</th>
                <th class="text-center">وارد</th>
                <th class="text-center">منصرف</th>
                <th class="text-center">الرصيد</th>
            </tr>
            </thead>
        </table>
    </div>
    <!-- /state saving -->

@endsection

@section('script')
    <script src="{{ asset('backend/global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script>
        var id = {{ $bank->id }};
        var url = '{{ route("bank.show.data", ":id") }}';
        url = url.replace(':id', id);
        var table = $('.datatable-button-init-basic').DataTable({
            // order: [[3, 'desc']],
            "pageLength": 100,
            ordering: false,
            // processing : true,
            // serverSide: true,
            ajax: url,
            columns: [
                {
                    data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: "type"},
                {data: "transaction_description"},
                {data: "transaction_date"},
                {data: "income"},
                {data: "expense"},
                {data: "total"},
            ],
        });
    </script>
@endsection
