@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ route('user.index') }}" class="breadcrumb-item">المستخدمين</a>
                    <span class="breadcrumb-item active">تعديل المستخدم</span>
                    <span class="breadcrumb-item active">{{ $user->name }}</span>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">تعديل المستخدم</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('user.update' , $user->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>اسم المستخدم</label>
                            <input type="text" class="form-control" name="name" placeholder="اسم المستخدم"
                                   value="{{ $user->name }}">
                            @error('name')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>الموبايل</label>
                            <input type="text" class="form-control" name="mobile" placeholder="الموبايل"
                                   value="{{ $user->mobile }}">
                            @error('mobile')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10">
                        <div class="form-group">
                            <label>كلمة السر</label>
                            <input type="text" class="form-control" name="password" placeholder="كلمة السر"
                                   value="{{ old('password') }}">
                            @error('password')
                            <label id="basic-error" class="validation-invalid-label"
                                   for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <input type="button" onclick="myFunction()" class="form-control btn btn-primary mt-4"
                                   value="تجديد كلمة السر">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('user.index') }}" class="btn btn-link">الغاء</a>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/notifications/pnotify.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/demo_pages/form_select2.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/demo_pages/form_multiselect.js') }}"></script>
    <script>
        function myFunction() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: "{{ route('generate-password') }}",
                success: function (data) {
                    console.log(data.data);
                    document.getElementsByName("password")[0].value = data.data;
                }
            });
        }
    </script>
@endsection
