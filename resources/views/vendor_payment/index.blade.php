@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">المدفوعات الى الموردين</span>
                </div>
                <a href="#" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="{{ route('vendor-payment.create') }}" class="breadcrumb-elements-item font-weight-bold">
                        <i class="icon-plus2 mr-2"></i>
                        اضافة مدفوعات الى المورد جديدة
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('vendor-payment.index') }}" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>البحث باسم المورد</label>
                                    <select class="form-control select-search select2-hidden-accessible filter-select"
                                            data-fouc=""
                                            tabindex="-1" aria-hidden="true" name="vendor_id">
                                        <option value="">لا يوجد</option>
                                        @foreach($vendors as $vendor)
                                            <option
                                                value="{{ $vendor->id }}" {{ $vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-4">
                                <div class="form-group">
                                    <label></label>
                                    <button type="submit" class="btn btn-primary">بحث</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- State saving -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">المدفوعات الى الموردين</h5>
        </div>

        <table class="table datatable-button-init-basic table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center">التسلسل</th>
                <th class="text-center">اسم المورد</th>
                <th class="text-center">تاريخ المدفوعة</th>
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
    <script src="{{ asset('backend/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/demo_pages/form_select2.js') }}"></script>
    <script>
        var table = $('.datatable-button-init-basic').DataTable({
            // processing : true,
            // serverSide: true,
            ajax: '{{ route('vendor-payment.data' , ['vendor_id' => $vendor_id]) }}',
            columns: [
                {
                    data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: "vendor"},
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
