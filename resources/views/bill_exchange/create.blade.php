@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ route('billExchange.index') }}" class="breadcrumb-item">فواتير تحويلات</a>
                    <span class="breadcrumb-item active">اضافة فاتورة تحويلات جديدة</span>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">اضافة فاتورة تحويلات جديدة</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('billExchange.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>اختر المخزن المحول منه</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="stock_id" required>
                                <option value="">لايوجد</option>
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                            @error('stock_id')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>اختر المخزن المحول اليه</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="to_stock_id" required>
                                <option value="">لايوجد</option>
                            </select>
                            @error('to_stock_id')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
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
                <a href="{{ route('billExchange.index') }}" class="btn btn-link">الغاء</a>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/demo_pages/form_select2.js') }}"></script>

    <script>
        $('select[name="stock_id"]').on('change', function () {
            var id = $(this).val();
            if (id) {
                var url = "{{ route('ajax.stock' , ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    async: true,
                    cache: false,
                    success: function (data) {
                        $('select[name="to_stock_id"]').children().remove();
                        let newData = `<option value="">لايوجد</option>`;
                        $.each(data, function (key, value) {
                            newData += `<option value="${value.id}">${value.name}</option>`;
                        });
                        $('select[name="to_stock_id"]').append(newData);
                    }
                });
            }
        });
    </script>
@endsection
