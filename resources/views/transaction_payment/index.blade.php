@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">تحويلات البنوك</span>
                </div>
                <a href="#" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="{{ route('transaction-payment.create') }}" class="breadcrumb-elements-item font-weight-bold">
                        <i class="icon-plus2 mr-2"></i>
                        اضافة تحويل بنكى جديد
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
    <!-- State saving -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">تحويلات البنوك</h5>
        </div>

        <table class="table datatable-button-init-basic table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center">التسلسل</th>
                <th class="text-center">اسم البنك</th>
                <th class="text-center">تاريخ التحويل</th>
                <th class="text-center">القيمة</th>
                <th class="text-center">الحالة</th>
                <th class="text-center">تاريخ السداد</th>
                <th class="text-center">بنك السداد</th>
                <th class="text-center">الوصف</th>
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
            ajax: '{{ route('transaction-payment.data') }}',
            columns: [
                {
                    data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: "bank"},
                {data: "date"},
                {data: "value"},
                {
                    data: "status",
                    render: function (data, type) {
                        if(data == 1){
                            return '<span class="badge badge-flat border-success text-success ml-2">' + 'تم السداد' + '</span>';
                        }else{
                            return '<span class="badge badge-danger ml-2">' + 'لم يتم السداد' + '</span>';
                        }
                    }
                },
                {data: "received_date"},
                {data: "received_bank_id"},
                {data: "description"},
                {data: "actions"},
            ],
        });
    </script>
@endsection
