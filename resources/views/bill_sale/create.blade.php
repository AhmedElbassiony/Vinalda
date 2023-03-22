@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ route('billSale.index') }}" class="breadcrumb-item">فواتير مبيعات</a>
                    <span class="breadcrumb-item active">اضافة فاتورة مبيعات جديدة</span>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">اضافة فاتورة مبيعات جديدة</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('billSale.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>اختر العميل</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="client_id" required>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>اختر المخزن</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="stock_id" required>
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>اختر طريقة الدفع</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="method_id" required>
                                @foreach($methods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>تاريخ الفاتورة</label>
                            <input class="form-control" type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            @error('date')
                            <label id="basic-error" class="validation-invalid-label"
                                   for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>الملاحظات</label>
                            <input type="text" class="form-control" name="description" placeholder="الملاحظات"
                                   value="{{ old('description') }}">
                            @error('description')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('billSale.index') }}" class="btn btn-link">الغاء</a>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/demo_pages/form_select2.js') }}"></script>
@endsection
