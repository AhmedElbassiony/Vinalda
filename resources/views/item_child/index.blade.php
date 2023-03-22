@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">الاصناف</span>
                </div>
                <a href="#" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="{{ route('itemChildren.create') }}" class="breadcrumb-elements-item font-weight-bold">
                        <i class="icon-plus2 mr-2"></i>
                        اضافة صنف جديد
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
                    <form action="{{ route('itemChildren.index') }}" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>البحث بالمخزن</label>
                                    <select class="form-control select-search select2-hidden-accessible filter-select"
                                            data-fouc=""
                                            tabindex="-1" aria-hidden="true" name="stock_id">
{{--<option value="">لا يوجد</option>--}}
                                        @foreach($stocks as $stock)
                                            <option
                                                value="{{ $stock->id }}" {{ $stock_id == $stock->id ? 'selected' : '' }}>{{ $stock->name }}</option>
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
            <h5 class="card-title">الاصناف</h5>
        </div>

        <table class="table datatable-button-init-basic table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center">التسلسل</th>
                <th class="text-center">الكود</th>
                <th class="text-center">اسم الصنف</th>
                <th class="text-center">رقم اللوت</th>
                <th class="text-center">تاريخ الانتهاء</th>
                <th class="text-center">اجمالى المشتريات</th>
                <th class="text-center">اجمالى المبيعات</th>
                <th class="text-center">اجمالى المحول من المخزن</th>
                <th class="text-center">اجمالى المحول الى المخزن</th>
                <th class="text-center">الكمية المتوفرة</th>
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
            "pageLength": 100,
            
            ajax: '{{ route('itemChildren.data' , ['stock_id' => $stock_id]) }}',
            columns: [
                {
                    data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: "code"},
                {data: "item"},
                {data: "lot_number"},
                {data: "expire_date"},
                {data: "count_purchase"},
                {data: "count_sale"},
                {data: "count_from"},
                {data: "count_to"},
                {data: "count"},
                {data: "actions"},
            ],
        });
    </script>
@endsection
