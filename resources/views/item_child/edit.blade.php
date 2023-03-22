@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ route('itemChildren.index') }}" class="breadcrumb-item">الاصناف</a>
                    <span class="breadcrumb-item active">تعديل الصنف</span>
                    <span class="breadcrumb-item active">{{ $itemChild->item->name ?? null  }}</span>
                    <span class="breadcrumb-item active">{{ $itemChild->lot_number ?? 'بدون'  }}</span>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">تعديل الصنف</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('itemChildren.update' , $itemChild->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>اختر الصنف الرئيسى</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="item_id" required>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ $itemChild->item_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>تاريخ انتهاء الصلاحية</label>
                            <input class="form-control" type="date" name="expire_date" value="{{ $itemChild->expire_date ? $itemChild->expire_date->format('Y-m-d') : null }}">
                            @error('expire_date')
                            <label id="basic-error" class="validation-invalid-label"
                                   for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>رقم اللوت</label>
                            <input type="text" class="form-control" name="lot_number" placeholder="رقم اللوت"
                                   value="{{ $itemChild->lot_number }}">
                            @error('lot_number')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('itemChildren.index') }}" class="btn btn-link">الغاء</a>
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
