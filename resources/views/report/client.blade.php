@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">تقارير</span>
                    <span class="breadcrumb-item active">تقرير كشف حساب عميل</span>
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
                    <h5 class="card-title">تقرير كشف حساب عميل</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('generate_pdf') }}" method="get" target="_blank">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>البحث باسم العميل</label>
                                    <select class="form-control select-search select2-hidden-accessible filter-select"
                                            data-fouc=""
                                            tabindex="-1" aria-hidden="true" name="client_id">
                                        @foreach($clients as $client)
                                            <option
                                                value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>البحث التاريخ من</label>
                                    <input type="date" class="form-control" name="date_from" placeholder="البحث باسم المجلد"
                                           value="{{  now()->startOfMonth()->format('Y-m-d') ?? $date_from }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>البحث التاريخ الى</label>
                                    <input type="date" class="form-control" name="date_to" placeholder="البحث باسم المجلد"
                                           value="{{ now()->endOfMonth()->format('Y-m-d') ?? $date_to  }}">
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
