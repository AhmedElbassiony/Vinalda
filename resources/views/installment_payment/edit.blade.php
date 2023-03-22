@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ $bill->type == 'sale' ? route('billSale.index') : route('billPurchase.index') }}" class="breadcrumb-item">
                        {{ $bill->type == 'sale' ? 'فواتير مبيعات' : 'فواتير مشتريات' }}
                    </a>
                    <a href="{{ $bill->type == 'sale' ? route('billSale.edit' , $bill->id) : route('billPurchase.edit' , $bill->id) }}" class="breadcrumb-item">الفاتورة</a>
                    <span class="breadcrumb-item active">{{ $bill->code }}</span>
                    <a href="{{ route('installment-payment.index' , $bill->id) }}" class="breadcrumb-item">الاقساط</a>
                    <span class="breadcrumb-item active">تعديل قسط</span>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">تعديل قسط</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('installment-payment.update' , ['bill' => $bill->id , 'installment_payment' => $payment->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>تاريخ المدفوعة</label>
                            <input class="form-control" type="date" name="date"
                                   value="{{ $payment->date->format('Y-m-d') }}">
                            @error('date')
                            <label id="basic-error" class="validation-invalid-label"
                                   for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>القيمة</label>
                            <input type="number" class="form-control" name="value" placeholder="القيمة"
                                   value="{{ $payment->value }}" step=any required>
                            @error('value')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>حالة السداد</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="status" required>
                                <option value="0" {{ !$payment->status ? 'selected' : '' }}>لم يتم السداد</option>
                                <option value="1" {{ $payment->status ? 'selected' : '' }}>تم السداد</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>تاريخ السداد</label>
                            <input class="form-control" type="date" name="received_date"
                                   value="{{ $payment->received_date->format('Y-m-d') }}">
                            @error('received_date')
                            <label id="basic-error" class="validation-invalid-label"
                                   for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>اختر بنك السداد</label>
                            <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                    tabindex="-1" aria-hidden="true" name="received_bank_id" required>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ $payment->bank_id == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>الملاحظات</label>
                            <input type="text" class="form-control" name="description" placeholder="الملاحظات"
                                   value="{{ $payment->description }}">
                            @error('description')
                            <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('installment-payment.index' , $bill->id) }}" class="btn btn-link">الغاء</a>
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
