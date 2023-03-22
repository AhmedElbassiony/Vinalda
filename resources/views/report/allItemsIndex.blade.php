@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">التقارير</span>
                    <span class="breadcrumb-item active">تقرير كشف اجمالي مبيعات الاصناف
                    </span>
                </div>
                <a href="#" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
            </div>

            {{-- <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="{{ route('billSale.create') }}" class="breadcrumb-elements-item font-weight-bold">
                        <i class="icon-plus2 mr-2"></i>
                        اضافة فاتورة مبيعات جديدة
                    </a>
                </div>
            </div> --}}

        </div>
    </div>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success border-0 alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <p class="font-weight-semibold">{{ Session::get('success') }}</p>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger border-0 alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <p class="font-weight-semibold">{{ Session::get('error') }}</p>
        </div>
    @endif
    <!-- State saving -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">تقرير كشف اجمالي مبيعات الاصناف</h5>
        </div>

        <table class="table datatable-button-init-basic table-bordered text-center">
            <thead>
                <tr>
                    <th class="text-center">التسلسل</th>
                    <th class="text-center">اسم الصنف</th>


                    @foreach ($months as $month)
                        <th class="text-center">{{ $month }}</th>
                        @php
                          $count++;
                        @endphp
                    @endforeach

                    <th class="text-center" >اجمالي المبيعات لمدة {{$count}}شهر </th>
                    <th class="text-center">اجمالي المشتريات لمدة {{$count}} شهر </th>
                    <th class="text-center"> الرصيد  </th>
                    <th class="text-center">المطلوب شرائه لمدة {{$count}} شهر </th>
                   

                </tr>

            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>

                        <td class="text-center">{{ $item->id }}</td>
                        <td class="text-center">{{ $item->item->name }}</td>

                        @foreach ($months as $m)
                            @if (in_array(['id' => $item->id, 'month' => $m], $itemPayment))
                                @php
                                    $keyPayments = array_search(['id' => $item->id, 'month' => $m], $itemPayment);
                                    if(in_array(['id' => $item->id], $itemPurchase))
                                    {
                                        $keyPurchases = array_search(['id' => $item->id], $itemPurchase);
                                        $Purchases =(int) $itemsDeatailsPurchase[$keyPurchases]->purchases;
                                    }
                                    $keyPurchasesAll = array_search(['id' => $item->id], $itemPurchases);
                                    $keySalesAll = array_search(['id' => $item->id], $itemSales);
                                    $total += (int) $itemsDeatailsPayments[$keyPayments]->payments;
                                    $rest = (int) $itemsPurchasesAll[$keyPurchasesAll]->payments -  (int) $itemsSalessAll[$keySalesAll]->payments  ;
                                    $payments=(int)$itemsDeatailsPayments[$keyPayments]->payments;
                                @endphp

                                <td class="text-center">{{$payments}}</td>
                            @else
                                <td class="text-center">{{ 0 }}</td>
                            @endif
                            
                        @endforeach
                        <td class="text-center">{{ $total }}</td>
                        <td class="text-center">{{ $Purchases }}</td>
                        <td class="text-center">{{ $rest  }}</td>
                        <td class="text-center">{{ $total-$rest  }}</td>
                        @php
                            
                            $total = 0;
                            $rest = 0;
                            $Purchases=0;
                            
                        @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /state saving -->
@endsection

@section('script')
    <script src="{{ asset('backend/global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script>
        var table = $('.datatable-button-init-basic').DataTable({
            // processing : true,
            // serverSide: true,
            "pageLength": 50,
            ordering: false,
    
        });
    </script>
@endsection
