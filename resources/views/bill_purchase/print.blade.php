<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
    <title>{{ $billPurchase->code }}</title>
    <style type="text/css">
        @media print {
            * {
                color-adjust: exact;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .invoice-box {
                padding: 0 !important;
                margin: 0 !important;
            }
        }

        @page {
            size: auto;   /* auto is the initial value */
            margin: 35mm 15mm 15mm;
        }

        .invoice-box {
            /*max-width: 800px;*/
            margin: auto;
            padding: 30px;
            font-size: 14px;
            line-height: 1.25;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #000;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 5px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #000;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }


            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            /*direction: rtl;*/
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        /*.invoice-box.rtl table {*/
        /*    text-align: right;*/
        /*}*/

        /*.invoice-box.rtl table tr td:nth-child(2) {*/
        /*    text-align: left;*/
        /*}*/

        .background-tr {
            background-color: #ddd !important;
            padding: 6px;
            border: 1px solid #000;
            text-align: center !important;
        }

        .new-table {
            font-size: 20px;
            font-weight: bold;

        }

        .height_line {
            line-height: 1.5;
        }

        /*body.rtl {*/
        /*    text-align: right;*/
        /*}*/

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: transparent;
        }

        .table th, .table td {
            padding: 0.5rem !important;
            border-top: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
        }

        .table-responsive-sm table td, .table-responsive-sm table th {
            border: 1px solid #000 !important;
            font-weight: bold;
        }
    </style>

</head>

<body class="rtl" dir="rtl">
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <div class="text-center h3 font-weight-bold background-tr w-50 m-auto">
            <span>عرض السعر</span>
        </div>
        <tr class="top">
            <td colspan="2">
                <table class="new-table my-3">
                    <tr>
                        <td class="title">
                        </td>

                        <td class="height_line" style="font-size: 18px">
                            رقم الفاتورة : <span>{{ $billPurchase->code  }}</span><br/>
                            تاريخ الفاتورة : <span>{{ $billPurchase->date->format('Y-m-d') ?? null  }}</span><br/>
                            اسم المورد : <span>{{ $billPurchase->vendor->name ?? null  }}</span> <br/>
                            رقم التليفون : <span>{{ $billPurchase->vendor->mobile ?? null  }}</span> <br/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="table-responsive-sm">
        <table class="table table-striped text-center table-bordered">
            <thead>
            <tr>
                <th class="center">مسلسل</th>
                <th class="center">كود الصنف</th>
                <th class="center">إسم الصنف</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>الإجمالي</th>

            </tr>
            </thead>
            <tbody>
            @foreach($billPurchase->items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $item->code }}</td>
                    <td class="text-center">{{ $item->item->name ?? null }}</td>
                    <td class="text-center">{{ $item->pivot->count ?? null }}</td>
                    <td class="text-center">{{ round($item->pivot->price ?? 0 ,2) }}</td>
                    <td class="text-center">{{ round($item->pivot->price ?? 0 ,2) * ($item->pivot->count ?? null) }}</td>
                </tr>
            @endforeach

            <tr class="background-tr">
                <td colspan="5">الإجمالي</td>
                <td class="text-center">{{ round($total , 2) }}</td>
            </tr>
            </tbody>
        </table>

    </div>
    {{--    <div class="text-center h6">س.ت 97441 م.ض 04-50-191-00522-5-173 ب.ض 024-574-579</div>--}}
    <table style="width:100% !important;" class="table mt-2">
        <tr>
            <td style="font-size: 15px; border: 0 !important;" class="font-weight-bold text-center">الاجمالى :</td>
            <td style="font-size: 15px; border: 0 !important;"
                class="font-weight-bold text-center">{{ round($total , 2)  }}</td>
            <td style="font-size: 15px; border: 0 !important;" class="font-weight-bold text-center">جنية</td>
            <td style="font-size: 15px; border: 0 !important;" class="font-weight-bold text-center">المدفوع :</td>
            <td style="font-size: 15px; border: 0 !important;"
                class="font-weight-bold text-center">{{ round($paid , 2) }}</td>
            <td style="font-size: 15px; border: 0 !important;" class="font-weight-bold text-center">جنية</td>
            <td style="font-size: 15px; border: 0 !important;" class="font-weight-bold text-center">الباقى :</td>
            <td style="font-size: 15px; border: 0 !important;"
                class="font-weight-bold text-center">{{ round($total , 2) - round($paid , 2) }}</td>
            <td style="font-size: 15px; border: 0 !important;" class="font-weight-bold text-center">جنية</td>
        </tr>
        <tr class="mt-2">
            <td colspan="1" style="font-size: 15px; border: 0 !important;" class="font-weight-bold text-center">طريقة
                الدفع :
            </td>
            <td colspan="8" style="font-size: 15px; border: 0 !important;"
                class="font-weight-bold text-center">{{ $billPurchase->method->name ?? null }}</td>
        </tr>
        <tr class="mt-2">
            <td colspan="1" style="font-size: 15px; border: 0 !important;" class="font-weight-bold text-center">ملاحظات
                :
            </td>
            <td colspan="8" style="font-size: 15px; border: 0 !important;"
                class="font-weight-bold text-center">{{ $billPurchase->description }}</td>
        </tr>
    </table>
</div>
{{--<footer class="text-center">--}}
{{--    <!-- Copyright -->--}}
{{--    <div class="text-center" style="position: fixed;bottom: 0;right: 0;left: 0;">--}}
{{--        © 2020 Copyright:--}}
{{--    </div>--}}
{{--    <!-- Copyright -->--}}
{{--</footer>--}}

</body>
<script type="text/javascript">
    window.onload = function () {
        window.print();
    }
</script>
</html>

