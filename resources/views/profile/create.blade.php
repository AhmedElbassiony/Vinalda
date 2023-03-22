@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">حسابى</span>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">تغيير كلمة السر</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('profile.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>كلمة المرور القديمة</label>
                            <input type="password" class="form-control" name="oldPassword" placeholder="كلمة المرور القديمة"
                                   value="{{ old('oldPassword') }}" required>
                            @if(Session::has('error'))
                                <label id="basic-error" class="validation-invalid-label" for="basic">{{ Session::get('error') }}</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" name="password" placeholder="كلمة المرور الجديدة"
                                   value="{{ old('password') }}" required>
                            @error('password')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>تاكيد كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="تاكيد كلمة المرور الجديدة"
                                   value="{{ old('password_confirmation') }}" required>
                            @error('password_confirmation')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('dashboard') }}" class="btn btn-link">الغاء</a>
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
