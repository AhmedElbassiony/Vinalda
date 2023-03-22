@extends('layouts.dashboard')

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <span class="breadcrumb-item active">التقارير</span>
                    <span class="breadcrumb-item active"> تقرير اجمالي مبيعات العملاء
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
            <h5 class="card-title"> تقرير اجمالي مبيعات العملاء</h5>
        </div>

        <table class="table datatable-button-init-basic table-bordered text-center">
            <thead>
                <tr>
                    <th class="text-center">التسلسل</th>
                    <th class="text-center">اسم العميل</th>
                    <th class="text-center"> اجمالي المبيعات </th>
                    <th class="text-center"> اجمالي الاقساط (تم السداد)</th>
                    <th class="text-center"> اجمالي المدفوعات (تم السداد)</th>
                    <th class="text-center">الباقي</th>
                    <th class="text-center"> اجمالي الاقساط (لم يتم السداد)</th>
                    <th class="text-center"> اجمالي المدفوعات (لم يتم السداد)</th>

                </tr>

            </thead>
            <tfoot align="center">
                <tr style="background-color: lightgray">
                    <th colspan="2"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th ></th>
                    <th ></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /state saving -->
@endsection

@section('script')
    <script src="{{ asset('backend/global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script>
        var table = $('.datatable-button-init-basic').DataTable({
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // converting to interger to find total
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // computing column Total of the complete result 
                var monTotal = api
                    .column(2 )
                    .data()
                    .reduce(function(a, b) {
                        var r = intVal(a) + intVal(b);
                        var s = new Intl.NumberFormat().format(r);
                        return s;
                    }, 0);

                var tueTotal = api
                    .column(3 )
                    .data()
                    .reduce(function(a, b) {
                        var r = intVal(a) + intVal(b);
                        var s = new Intl.NumberFormat().format(r);
                        return s;
                    }, 0);

                var wedTotal = api
                    .column(4  )
                    .data()
                    .reduce(function(a, b) {
                        var r = intVal(a) + intVal(b);
                        var s = new Intl.NumberFormat().format(r);
                        return s;
                    }, 0);

                var thuTotal = api
                    .column(5  )
                    .data()
                    .reduce(function(a, b) {
                        var r = intVal(a) + intVal(b);
                        var s = new Intl.NumberFormat().format(r);
                        return s;
                       
                    }, 0);

                var friTotal = api
                    .column(6 )
                    .data()
                    .reduce(function(a, b) {
                        var r = intVal(a) + intVal(b);
                        var s = new Intl.NumberFormat().format(r);
                        return s;
                    }, 0);

                var friTotalu = api
                    .column(7)
                    .data()
                    .reduce(function(a, b) {
                        var r = intVal(a) + intVal(b);
                        var s = new Intl.NumberFormat().format(r);
                        return s;
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                $(api.column(0 ).footer()).html('الاجمالي');
                $(api.column(2).footer()).html(monTotal);
                $(api.column(3).footer()).html(tueTotal);
                $(api.column(4).footer()).html(wedTotal);
                $(api.column(5).footer()).html(thuTotal);
                $(api.column(6).footer()).html(friTotal);
                $(api.column(7).footer()).html(friTotalu);
            },



            // processing : true,
            // serverSide: true,
            "pageLength": 100,
            ajax: '{{ route('report.allClientsData') }}',
            columns: [{
                    data: "id",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "name"
                },
                {
                    data: "total_payments"
                },
                {
                    data: "payments_true"
                },
                {
                    data: "client_payments_true"
                },
                {
                    data: "rest"
                },
                {
                    data: "client_payments_false"
                },
                {
                    data: "payments_false"
                },


            ],
            createdRow: (row, data, dataIndex, cells) => {
                $(cells[7]).css('background-color', '#d9534f')
                $(cells[6]).css('background-color', '#d9534f')
            },
        });
    </script>
@endsection
