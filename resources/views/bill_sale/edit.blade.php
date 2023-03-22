@extends('layouts.dashboard')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {{--    <link href="{{ asset('kendo/content/shared/styles/examples-offline.css') }}" rel="stylesheet">--}}
    {{--    <link href="{{ asset('kendo/styles/kendo.rtl.min.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('kendo/styles/kendo.common.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('kendo/styles/kendo.material.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('kendo/styles/kendo.material.mobile.min.css') }}"/>
    <style>
        a:link {
            text-decoration: none !important;
        }

        .k-grid-content .k-alt {
            background-color: #ebebeb;
        }

        .k-grid tr:hover {
            background-color: #a19a9a !important;
        }

        /*.k-filter-row th{*/
        /*    text-align: center !important;*/
        /*}*/

        .k-filtercell > span {
            padding-right: 2.8em !important;
        }

        .k-filter-row .k-dropdown-operator {
            right: 0em !important;
        }

        .k-autocomplete > .k-i-close {
            left: calc(1em - 8px) !important;
        }

        k-filter-row > th:first-child, .k-grid tbody td:first-child, .k-grid tfoot td:first-child, .k-grid-header th.k-header:first-child {
            border-left-width: 1px !important;
        }

        .k-master-row .k-checkbox.checked {
            background-color: rgba(255, 99, 88, .25) !important;
        }

        .background-cell {
            background-color: #e1e6e9;
            /*background-color: #e1e6e9;*/
        }

        .k-grid .k-hierarchy-cell + td {
            border-left-width: 1px !important;
        }

        div.k-grid-footer, div.k-grid-header {
            padding-left: 6px !important;
            padding-right: unset !important;
        }

        .k-filter-row th, .k-grid-header th.k-header {
            text-align: right !important;
        }

        #tabstrip {
            display: none;
        }

    </style>
@endsection

@section('title')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{ route('billSale.index') }}" class="breadcrumb-item"> فواتير مبيعات</a>
                    <span class="breadcrumb-item active">تعديل الفاتورة</span>
                    <span class="breadcrumb-item active">{{ $billSale->code }}</span>
                    <span class="breadcrumb-item active">{{ $billSale->client->name ?? null }}</span>
                    <span class="breadcrumb-item active">{{ $billSale->stock->name ?? null }}</span>
                </div>
                <a href="#" class="header-elements-toggle text-body d-md-none"><i class="icon-more"></i></a>
            </div>

            {{--            <div class="header-elements d-none">--}}
            {{--                <div class="breadcrumb justify-content-center">--}}
            {{--                    <a href="{{ route('cost.create' , $bills_purchase->id) }}"--}}
            {{--                       class="breadcrumb-elements-item font-weight-bold">--}}
            {{--                        <i class="icon-plus2 mr-2"></i>--}}
            {{--                        اضافة مصروفات جديدة--}}
            {{--                    </a>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>
@endsection

@section('content')
    <div id="tabstrip">
        <ul>
            <li id="tab1" class="k-state-active">اصناف الفاتورة</li>
            <li id="tab3">بيانات الفاتورة</li>
        </ul>
        <div>
            <div id="grid1"></div>
            <div id="grid2"></div>
        </div>
        <div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('billSale.update' , $billSale->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>اختر العميل</label>
                                    <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                            tabindex="-1" aria-hidden="true" name="client_id" required>
                                        @foreach($clients as $client)
                                            <option
                                                value="{{ $client->id }}" {{ $billSale->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>اسم المخزن</label>
                                    <input type="text" class="form-control" name="stock" placeholder="اسم المخزن"
                                           value="{{ $billSale->stock->name ?? null }}" style="box-sizing: border-box" readonly>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>تاريخ الفاتورة</label>
                                    <input class="form-control" type="date" name="date"
                                           value="{{ $billSale->date->format('Y-m-d') }}"
                                           style="box-sizing: border-box">
                                    @error('date')
                                    <label id="basic-error" class="validation-invalid-label"
                                           for="basic">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>اختر طريقة الدفع</label>
                                    <select class="form-control select-search select2-hidden-accessible" data-fouc=""
                                            tabindex="-1" aria-hidden="true" name="method_id" required>
                                        @foreach($methods as $method)
                                            <option value="{{ $method->id }}" {{ $billSale->method_id == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-11">
                                <div class="form-group">
                                    <label>الملاحظات</label>
                                    <input type="text" class="form-control" name="description" placeholder="الملاحظات"
                                           value="{{ $billSale->description }}">
                                    @error('description')
                                    <label id="basic-error" class="validation-invalid-label" for="basic">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <a href="{{ route('billSale.index') }}" class="btn btn-link">الغاء</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{--        <script src="{{ asset('kendo/js/jquery.min.js') }}"></script>--}}
    <script src="{{ asset('kendo/js/jszip.min.js') }}"></script>
    <script src="{{ asset('kendo/js/kendo.all.min.js') }}"></script>
    <script src="{{ asset('kendo/content/shared/js/console.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#tabstrip').show();
            var tabstrip = $("#tabstrip").kendoTabStrip().data("kendoTabStrip");
            $("#grid1").css("font-weight", "bold");
            $("#grid1").css("font-size", "12px");
            //apilinks

            var crudServiceBaseUrl = "https://app.kianmedicaleg.com/api/",
            // var crudServiceBaseUrl = "http://127.0.0.1:8000/api/",
                dataSource1 = new kendo.data.DataSource({
                    transport: {
                        read: {
                            {{--url: crudServiceBaseUrl + "items-sale  + '?bill_id=' + {{ $billSale->id }}",--}}
                            url: crudServiceBaseUrl + "items-sale/" + {{ $billSale->id }},
                            dataType: "json",
                        },

                        create: {
                            url: crudServiceBaseUrl + "add/item",
                            dataType: "json",
                            type: "POST",
                        },
                    },
                    schema: {
                        model: {
                            id: "id",
                            fields: {
                                id: {editable: false},
                                item: {editable: false, type: "string"},
                                // code: {editable: false, type: "string"},
                                lot_number: {editable: false, type: "string"},
                                count: {editable: false, type: "string"},
                                stock: {editable: false, type: "string"},
                                expire_date: {editable: false, type: "date"},
                            }
                        }
                    }
                });

            $("#grid1").kendoGrid({
                dataSource: dataSource1,
                height: 250,
                editable: true,
                pageable: {
                    refresh: true,
                    pageSizes: true,
                },
                sortable: true,
                resizable: true,
                reorderable: true,
                filterable: {
                    mode: "row"
                },
                dataBound: onDataBound,
                toolbar: ["excel", "search"],
                excelExport: function (e) {
                    var sheet = e.workbook.sheets[0];
                    for (var rowIndex = 1; rowIndex < sheet.rows.length; rowIndex++) {
                        if (rowIndex % 2 == 0) {
                            var row = sheet.rows[rowIndex];
                            for (var cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
                                row.cells[cellIndex].background = "#aabbcc";
                            }
                        }
                    }
                },
                // requestEnd: onRequestEnd,
                columns: [{
                    field: "item",
                    title: "اسم الصنف",
                    width: 100
                },
                    // {field: "code", title: "الكود", width: 100},
                    {field: "expire_date", title: "تاريخ الانتهاء", width: 100, format: "{0:dd/MM/yyyy}"},
                    {field: "lot_number", title: "رقم اللوت", width: 100},
                    {field: "count", title: "الكمية", width: 100},
                    {field: "stock", title: "المخزن", width: 100},
                    {command: {text: "اضافة صنف", click: addItem}, title: " ", width: "180px"}
                ],
            });


            function onDataBound(e) {
                var grid = this;
                grid.table.find("tr").each(function () {
                    var dataItem = grid.dataItem(this);
                    kendo.bind($(this), dataItem);
                });
            }

            function addItem(e) {
                e.preventDefault();

                var dataItem = this.dataItem($(e.currentTarget).closest("tr"));

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('item.sale.store' , ['billId' => $billSale->id]) }}",
                    data: {id: dataItem.id},
                    success: function (data) {
                        if (data == 'success') {
                            $('#grid1').data('kendoGrid').dataSource.read();
                            $('#grid1').data('kendoGrid').refresh();
                            $('#grid2').data('kendoGrid').dataSource.read();
                            $('#grid2').data('kendoGrid').refresh();
                        } else {
                            alert(" Error ! ");
                        }
                    }
                });
            }

            //////////////////////////grid 2 /////////////////////////////////////////

            $("#grid2").css("font-weight", "bold");
            $("#grid2").css("font-size", "12px");
            dataSource2 = new kendo.data.DataSource({
                transport: {
                    read: {
                        url: crudServiceBaseUrl + "bill/" + {{ $billSale->id }} + '?bill_id=' + {{ $billSale->id }},
                        dataType: "json",
                    },
                    update: {
                        url: crudServiceBaseUrl + "bill/update/" + {{ $billSale->id }},
                        dataType: "json",
                        type: "POST",
                        complete: function (e) {
                            $("#grid2").data("kendoGrid").dataSource.read();
                            $("#grid1").data("kendoGrid").dataSource.read();
                            $("#grid2").data("kendoGrid").dataSource.read();
                        }
                    },
                    destroy: {
                        url: crudServiceBaseUrl + "bill/destroy/" + {{ $billSale->id }},
                        dataType: "json",
                        complete: function (e) {
                            $("#grid1").data("kendoGrid").dataSource.read();
                        }
                    },
                },
                batch: true,
                autoSync: true,
                schema: {
                    model: {
                        id: "id",
                        fields: {
                            id: {editable: false},
                            name: {editable: false},
                            lot_number: {editable: false},
                            count: {type: "number"},
                            stock: {editable: false},
                            price: {type: "number"},
                            total_price: {editable: false, type: "number", aggregate: "sum"},
                            discount_type: {defaultValue: "نسبة %"},
                            discount: {type: "number"},
                        // , validation: { max: 100 }
                            tax_type: {defaultValue: "نسبة %"},
                            tax: {type: "number"},
                            status: {type: "boolean"},
                        }
                    }
                }
            });

            $("#grid2").kendoGrid({
                dataSource: dataSource2,
                height: 400,
                editable: {
                    confirmation: "هل انت متاكد من حذف الصنف من الفاتورة؟"
                },
                edit: function (e) {
                    var fieldName = e.model.status;
                    // var fieldId = e.model.id;
                    if (fieldName === true) {
                        {{--var x = {{ \App\Models\ItemChild::find(fieldId) }}--}}
                        // e.container.find('input[name=received]').attr('disabled', true)
                        this.closeCell(); // prevent editing
                    }
                    return true;
                },
                pageable: {
                    refresh: true,
                    pageSizes: true,
                },
                sortable: true,
                // filterable: {
                //     mode: "row"
                // },
                resizable: true,
                reorderable: true,
                dataBound: onDataBoundAnother,
                toolbar: ["excel", "search"],
                excelExport: function (e) {
                    var sheet = e.workbook.sheets[0];
                    for (var rowIndex = 1; rowIndex < sheet.rows.length; rowIndex++) {
                        if (rowIndex % 2 == 0) {
                            var row = sheet.rows[rowIndex];
                            for (var cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
                                row.cells[cellIndex].background = "#aabbcc";
                            }
                        }
                    }
                },
                // requestEnd: onRequestEnd,
                columns: [
                    {field: "name", title: "اسم الصنف", width: 200},
                    {field: "lot_number", title: "رقم اللوت", width: 100},
                    {field: "count", title: "العدد", width: 100},
                    {field: "stock", title: "اسم المخزن", width: 100,},
                    {field: "price", title: "السعر الاصلى", format: "{0:n4}", width: 100},
                    {field: "total_price", title: "السعر الاجمالى", format: "{0:n4}", width: 100},
                    {
                        field: "discount_type",
                        title: "نوع الخصم",
                        editor: discountTypeEditor,
                        width: 100,
                    },
                    {field: "discount", title: "الخصم", width: 100},
                    {
                        field: "tax_type",
                        title: "نوع الضريبة",
                        editor: taxTypeEditor,
                        width: 100,
                    },
                    {field: "tax", title: "الضرايب", width: 100},
                    {
                        field: "status",
                        title: "تم الاستلام؟",
                        editor: customBoolEditor,
                        width: 150,
                        template: '<input class="k-checkbox" type="checkbox" #= status ? \'checked="checked"\' : "" # class="chkbx" id="chk_#=id#"/>',
                    },
                    {
                        command: [
                            {name: "destroy", text: "حذف"},
                        ],
                        title: "&nbsp;",
                        width: "100px"
                    }
                ],
            });

            //apply the activate event, which is thrown only after the animation is played out
            tabstrip.one("activate", function () {
                grid.resize();
            });

            function onDataBoundAnother(e) {
                var grid = this;
                grid.table.find("tr").each(function () {
                    var dataItem = grid.dataItem(this);
                    if (dataItem.status) {
                        $(this).attr("style", "background-color: gray !important; height:42px");
                        $(this).find('.k-grid-delete').removeClass('k-grid-delete');
                    }
                    kendo.bind($(this), dataItem);
                });
            }

            function discountTypeEditor(container, options) {
                $('<input required name="discount_type">')
                    .appendTo(container)
                    .kendoDropDownList({
                        autoBind: false,
                        dataSource:
                            [ "مبلغ" ,"نسبة %"],
                    });
            }

            function taxTypeEditor(container, options) {
                $('<input required name="tax_type">')
                    .appendTo(container)
                    .kendoDropDownList({
                        autoBind: false,
                        dataSource:
                            [ "مبلغ" ,"نسبة %"],
                    });
            }

            function customBoolEditor(container, options) {
                if (options.model.status == false) {
                    var agree = confirm('هل انت متاكد من استلام الصنف؟');
                    if (agree) {
                        options.model.set("status", true);
                    } else {
                        options.model.set("status", false);
                    }
                } else {
                    var agree1 = confirm('هل انت متاكد من عدم استلام الصنف؟');
                    if (agree1) {
                        options.model.set("status", false);
                    } else {
                        options.model.set("status", true);
                    }
                }

                $('<input class="k-checkbox" type="checkbox" name="status" data-type="boolean" data-bind="checked:status">').appendTo(container);
            }
        });



    </script>
    <script src="{{ asset('backend/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/global_assets/js/demo_pages/form_select2.js') }}"></script>
@endsection
