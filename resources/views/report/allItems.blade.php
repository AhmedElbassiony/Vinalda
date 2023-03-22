@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">تقارير</span>
                    <span class="breadcrumb-item active">تقرير كشف اجمالي مبيعات الاصناف</span>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">تقرير كشف اجمالي مبيعات الاصناف</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('report.allItemsIndex') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>البحث التاريخ من</label>
                                    <input type="month" class="form-control" min="2020-01"   max="<?= date('Y-m'); ?>" name="date_from" placeholder="البحث باسم المجلد"
                                          required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>البحث التاريخ الى</label>
                                    <input type="month" class="form-control" min="2020-01"  max="<?= date('Y-m'); ?>"  name="date_to" placeholder="البحث باسم المجلد"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-4">
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
@endsection

@section('script')
    <script src="{{ asset('backend/global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/demo_pages/form_select2.js') }}"></script>
@endsection
