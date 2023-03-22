<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex">
    <title>برنامج المبيعات</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="{{ asset('backend/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->


    @yield('style')

</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-dark navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-paragraph-justify3"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-transmission"></i>
        </button>
    </div>

    <div class="navbar-brand text-center text-lg-left">
        <a href="{{ route('dashboard') }}" class="d-inline-block">
            <img src="{{ asset('images/logo_light.png') }}" class="d-none d-sm-block" alt="">
            <img src="{{ asset('backend/global_assets/images/logo_icon_light.png') }}" class="d-sm-none" alt="">
        </a>
    </div>

    <div class="collapse navbar-collapse order-2 order-lg-1" id="navbar-mobile">


    </div>

    <ul class="navbar-nav flex-row order-1 order-lg-2 flex-1 flex-lg-0 justify-content-end align-items-center">
        <li class="nav-item nav-item-dropdown-lg dropdown dropdown-user h-100">
            <a href="#"
               class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle d-inline-flex align-items-center h-100"
               data-toggle="dropdown">
                <img src="{{ asset('backend/global_assets/images/avatar.png') }}" class="rounded-pill"
                     height="34" alt="">
                <span class="d-none d-lg-inline-block ml-2">{{ auth()->user()->name }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('profile.create') }}" class="dropdown-item"><i class="icon-user"></i> حسابى</a>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="icon-switch2"></i> تسجيل خروج</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</div>
<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">

    <!-- Main sidebar -->
    {{--    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">--}}
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg sidebar-main-resized">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- User menu -->
            <div class="sidebar-section sidebar-user my-1">
                <div class="sidebar-section-body">
                    <div class="media">
                        <a href="{{ route('dashboard') }}" class="mr-3">
                            <img src="{{ asset('backend/global_assets/images/avatar.png') }}"
                                 class="rounded-circle" alt="">
                        </a>

                        <div class="media-body">
                            <div class="font-weight-semibold">{{ auth()->user()->name }}</div>
                            <div class="font-size-sm line-height-sm opacity-50">
                                {{ 'ادمن' }}
                            </div>
                        </div>

                        <div class="ml-3 align-self-center">
                            <button type="button"
                                    class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>

                            <button type="button"
                                    class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user menu -->


            <!-- Main navigation -->
            <div class="sidebar-section">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">لوحة التحكم</div>
                        <i class="icon-menu" title="Main"></i></li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                            <i class="icon-home4"></i>
                            <span>
                                الرئيسية
                            </span>
                        </a>
                    </li>

                    <li class="nav-item nav-item-submenu {{ Route::is(['category.*', 'brand.*', 'stock.*', 'expense.*', 'method.*' , 'governorate.*']) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link"><i class="icon-gear"></i>
                            <span>الاعدادات</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item">
                                <a href="{{ route('governorate.index') }}"
                                   class="nav-link {{ Route::is('governorate.*') ? 'active' : '' }}">
                                    <span>المحافظات</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('category.index') }}"
                                   class="nav-link {{ Route::is('category.*') ? 'active' : '' }}">
                                    <span>الفئات</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('brand.index') }}"
                                   class="nav-link {{ Route::is('brand.*') ? 'active' : '' }}">
                                    <span>العلامات التجارية</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('stock.index') }}"
                                   class="nav-link {{ Route::is('stock.*') ? 'active' : '' }}">
                                    <span>المخازن</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('expense.index') }}"
                                   class="nav-link {{ Route::is('expense.*') ? 'active' : '' }}">
                                    <span>انواع المصروفات</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('method.index') }}"
                                   class="nav-link {{ Route::is('method.*') ? 'active' : '' }}">
                                    <span>طرق الدفع</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('clients.index') }}"
                           class="nav-link {{ Route::is('clients.*') ? 'active' : '' }}">
                            <i class="icon-users"></i>
                            <span>
                                العملاء
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('vendors.index') }}"
                           class="nav-link {{ Route::is('vendors.*') ? 'active' : '' }}">
                            <i class="icon-user-tie"></i>
                            <span>
                                الموردين
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('items.index') }}"
                           class="nav-link {{ Route::is('items.*') ? 'active' : '' }}">
                            <i class="icon-cart"></i>
                            <span>
                                الاصناف الرئيسية
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('itemChildren.index') }}"
                           class="nav-link {{ Route::is('itemChildren.*') ? 'active' : '' }}">
                            <i class="icon-cart5"></i>
                            <span>
                                الاصناف
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('billPurchase.index') }}"
                           class="nav-link {{ Route::is('billPurchase.*') ? 'active' : '' }}">
                            <i class="icon-printer"></i>
                            <span>
                                فواتير مشتريات
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('billSale.index') }}"
                           class="nav-link {{ Route::is('billSale.*') ? 'active' : '' }}">
                            <i class="icon-printer2"></i>
                            <span>
                                فواتير مبيعات
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('billExchange.index') }}"
                           class="nav-link {{ Route::is('billExchange.*') ? 'active' : '' }}">
                            <i class="icon-printer2"></i>
                            <span>
                                فواتير تحويلات
                            </span>
                        </a>
                    </li>

                    <li class="nav-item nav-item-submenu {{ Route::is(['bank.*', 'client-payment.*', 'vendor-payment.*' , 'transaction-payment.*' , 'expense-payment.*']) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link"><i class="icon-coins"></i>
                            <span>نظام العمليات البنكية</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item">
                                <a href="{{ route('bank.index') }}"
                                   class="nav-link {{ Route::is('bank.*') ? 'active' : '' }}">
                                    <span>البنوك</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('client-payment.index') }}"
                                   class="nav-link {{ Route::is('client-payment.*') ? 'active' : '' }}">
                                    <span> المدفوعات من العميل</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('vendor-payment.index') }}"
                                   class="nav-link {{ Route::is('vendor-payment.*') ? 'active' : '' }}">
                                    <span> المدفوعات الى الموردين</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('transaction-payment.index') }}"
                                   class="nav-link {{ Route::is('transaction-payment.*') ? 'active' : '' }}">
                                    <span> تحويلات البنوك</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('expense-payment.index') }}"
                                   class="nav-link {{ Route::is('expense-payment.*') ? 'active' : '' }}">
                                    <span> مصروفات عامة</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-item-submenu {{ Route::is(['report.*']) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link"><i class="icon-coins"></i>
                            <span>تقارير</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item">
                                <a href="{{ route('report.client') }}"
                                   class="nav-link {{ Route::is('report.client') ? 'active' : '' }}">
                                    <span>تقرير كشف حساب عميل</span>
                                </a>

                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.allClients') }}"
                                   class="nav-link {{ Route::is('report.allClients') ? 'active' : '' }}">
                                    <span>تقرير اجمالي مبيعات العملاء </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('report.allItems') }}"
                                   class="nav-link {{ Route::is('report.allItems') ? 'active' : '' }}">
                                    <span>تقرير كشف اجمالي مبيعات الاصناف</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                           class="nav-link {{ Route::is('user.*') ? 'active' : '' }}">
                            <i class="icon-user-plus"></i>
                            <span>
                                المستخدمين
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- Page header -->
            @yield('title')
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">
                @yield('content')
            </div>
            <!-- /content area -->


            <!-- Footer -->
            <div class="navbar navbar-expand-lg navbar-light border-bottom-0 border-top">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                            data-target="#navbar-footer">
                        <i class="icon-unfold mr-2"></i>
                        Footer
                    </button>
                </div>

                <div class="navbar-collapse collapse justify-content-center" id="navbar-footer">
<span class="navbar-text">
&copy; 2022. <a href="{{ route('dashboard') }}">برنامج المبيعات</a>
</span>
                </div>
            </div>
            <!-- /footer -->

        </div>
        <!-- /inner content -->
    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

<script src="{{ asset('backend/global_assets/js/main/jquery.min.js') }}"></script>
<script src="{{ asset('backend/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('backend/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('backend/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/app.js') }}"></script>
<!-- /theme JS files -->
<script>
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            "loadingRecords": "جارٍ التحميل...",
            "lengthMenu": "أظهر _MENU_ مدخلات",
            "zeroRecords": "لم يعثر على أية سجلات",
            "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            "infoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "search": "ابحث:",
            "paginate": {
                "first": "الأول",
                "previous": "السابق",
                "next": "التالي",
                "last": "الأخير"
            },
            "aria": {
                "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
            },
            "select": {
                "rows": {
                    "_": "%d قيمة محددة",
                    "1": "1 قيمة محددة"
                },
                "cells": {
                    "1": "1 خلية محددة",
                    "_": "%d خلايا محددة"
                },
                "columns": {
                    "1": "1 عمود محدد",
                    "_": "%d أعمدة محددة"
                }
            },
            "buttons": {
                "print": "طباعة",
                "copyKeys": "زر <i>ctrl<\/i> أو <i>⌘<\/i> + <i>C<\/i> من الجدول<br>ليتم نسخها إلى الحافظة<br><br>للإلغاء اضغط على الرسالة أو اضغط على زر الخروج.",
                "pageLength": {
                    "-1": "اظهار الكل",
                    "_": "إظهار %d أسطر"
                },
                "collection": "مجموعة",
                "copy": "نسخ",
                "copyTitle": "نسخ إلى الحافظة",
                "csv": "CSV",
                "excel": "Excel",
                "pdf": "PDF",
                "colvis": "إظهار الأعمدة",
                "colvisRestore": "إستعادة العرض",
                "copySuccess": {
                    "1": "تم نسخ سطر واحد الى الحافظة",
                    "_": "تم نسخ %ds أسطر الى الحافظة"
                }
            },
            "searchBuilder": {
                "add": "اضافة شرط",
                "clearAll": "ازالة الكل",
                "condition": "الشرط",
                "data": "المعلومة",
                "logicAnd": "و",
                "logicOr": "أو",
                "title": [
                    "منشئ البحث"
                ],
                "value": "القيمة",
                "conditions": {
                    "date": {
                        "after": "بعد",
                        "before": "قبل",
                        "between": "بين",
                        "empty": "فارغ",
                        "equals": "تساوي",
                        "not": "ليس",
                        "notBetween": "ليست بين",
                        "notEmpty": "ليست فارغة"
                    },
                    "number": {
                        "between": "بين",
                        "empty": "فارغة",
                        "equals": "تساوي",
                        "gt": "أكبر من",
                        "gte": "أكبر وتساوي",
                        "lt": "أقل من",
                        "lte": "أقل وتساوي",
                        "not": "ليست",
                        "notBetween": "ليست بين",
                        "notEmpty": "ليست فارغة"
                    },
                    "string": {
                        "contains": "يحتوي",
                        "empty": "فاغ",
                        "endsWith": "ينتهي ب",
                        "equals": "يساوي",
                        "not": "ليست",
                        "notEmpty": "ليست فارغة",
                        "startsWith": " تبدأ بـ "
                    }
                },
                "button": {
                    "0": "فلاتر البحث",
                    "_": "فلاتر البحث (%d)"
                },
                "deleteTitle": "حذف فلاتر"
            },
            "searchPanes": {
                "clearMessage": "ازالة الكل",
                "collapse": {
                    "0": "بحث",
                    "_": "بحث (%d)"
                },
                "count": "عدد",
                "countFiltered": "عدد المفلتر",
                "loadMessage": "جارِ التحميل ...",
                "title": "الفلاتر النشطة",
                "showMessage": "إظهار الجميع",
                "collapseMessage": "إخفاء الجميع"
            },
            "infoThousands": ",",
            "datetime": {
                "previous": "السابق",
                "next": "التالي",
                "hours": "الساعة",
                "minutes": "الدقيقة",
                "seconds": "الثانية",
                "unknown": "-",
                "amPm": [
                    "صباحا",
                    "مساءا"
                ],
                "weekdays": [
                    "الأحد",
                    "الإثنين",
                    "الثلاثاء",
                    "الأربعاء",
                    "الخميس",
                    "الجمعة",
                    "السبت"
                ],
                "months": [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "أبريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "أغسطس",
                    "سبتمبر",
                    "أكتوبر",
                    "نوفمبر",
                    "ديسمبر"
                ]
            },
            "editor": {
                "close": "إغلاق",
                "create": {
                    "button": "إضافة",
                    "title": "إضافة جديدة",
                    "submit": "إرسال"
                },
                "edit": {
                    "button": "تعديل",
                    "title": "تعديل السجل",
                    "submit": "تحديث"
                },
                "remove": {
                    "button": "حذف",
                    "title": "حذف",
                    "submit": "حذف",
                    "confirm": {
                        "_": "هل أنت متأكد من رغبتك في حذف السجلات %d المحددة؟",
                        "1": "هل أنت متأكد من رغبتك في حذف السجل؟"
                    }
                },
                "error": {
                    "system": "حدث خطأ ما"
                },
                "multi": {
                    "title": "قيم متعدية",
                    "restore": "تراجع"
                }
            },
            "processing": "جارٍ المعالجة...",
            "emptyTable": "لا يوجد بيانات متاحة في الجدول",
            "infoEmpty": "يعرض 0 إلى 0 من أصل 0 مُدخل",
            "thousands": ".",
            "stateRestore": {
                "creationModal": {
                    "columns": {
                        "search": "إمكانية البحث للعمود",
                        "visible": "إظهار العمود"
                    },
                    "toggleLabel": "تتضمن"
                }
            },
            "autoFill": {
                "cancel": "إلغاء الامر",
                "fill": "املأ كل الخلايا بـ <i>%d<\/i>",
                "fillHorizontal": "تعبئة الخلايا أفقيًا",
                "fillVertical": "تعبئة الخلايا عموديا"
            },
            "decimal": ","
        },
        buttons: {
            dom: {
                button: {
                    className: 'btn btn-light'
                }
            },
            buttons: [
                {extend: 'excel'},
            ]
        },
    });
</script>
@yield('script')
</body>
</html>
