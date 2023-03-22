@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ route('clients.index') }}" class="breadcrumb-item">العملاء</a>
                    <span class="breadcrumb-item active">اضافة عميل جديد</span>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">اضافة عميل جديد</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('clients.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>اسم العميل</label>
                            <input type="text" class="form-control" name="name" placeholder="اسم العميل"
                                   value="{{ old('name') }}" required>
                            @error('name')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>الموبايل</label>
                            <input type="number" class="form-control" name="mobile" placeholder="الموبايل"
                                   value="{{ old('mobile') }}" required>
                            @error('mobile')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>اختر المحافظة</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="governorate_id">
                                @foreach($governorates as $governorate)
                                    <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>العنوان التفصيلى</label>
                            <input type="text" class="form-control" name="address" placeholder="العنوان التفصيلى"
                                   value="{{ old('address') }}">
                            @error('address')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('clients.index') }}" class="btn btn-link">الغاء</a>
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
