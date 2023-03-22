<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Client Report</title>

    <style>
        body {
            font-family: 'XBRiyaz', sans-serif;
        }

        /*table.print-friendly tr td, table.print-friendly tr th {*/
        /*    page-break-inside: avoid;*/
        /*}*/
        /*.page-break {*/
        /*    page-break-inside: avoid;*/
        /*    !*page-break-bef:always;*!*/
        /*}*/
        /*.page-break { page-break-after:always }*/
        /*tr { page-break-inside:avoid; page-break-after:auto }*/
        .invoice-box {
            max-width: 800px;
            margin: auto;
            /*padding: 30px;*/
            /*border: 1px solid #eee;*/
            /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);*/
            font-size: 16px;
            line-height: 24px;
            font-family: 'XBRiyaz', sans-serif;
            color: #555;
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
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            background: #eee;
            font-size: 45px;
            line-height: 45px;
            color: #333;
            text-align: center;
        }

        /*.invoice-box table tr.information table td {*/
        /*    !*padding-bottom: 40px;*!*/
        /*}*/

        .invoice-box table tr.heading td {
            background: #eee;
            border: 1px solid #000;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border: 1px solid #000;
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
            direction: rtl;
            font-family: 'XBRiyaz', sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>

<body>

{{--<htmlpageheader name="page-header">--}}
{{--    <p style="text-align: center; margin-top: ">asdsa</p>--}}
{{--</htmlpageheader>--}}

{{--<htmlpagefooter name="page-footer">--}}
{{--    <p style="text-align: center">asdsa</p>--}}
{{--</htmlpagefooter>--}}


<div class="invoice-box rtl">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="5">
                <table>
                    <tr>
                        <td style="text-align: center;background: #000;color: white; font-size: 20px; padding: 0">
                            كشف حساب عميل<br>
                            {{ 'اسم العميل : ' . $client->name }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="5">
                <table>
                    <tr>
                        <td style="text-align: center;padding: 0">
                            {{ 'خلال الفترة من : ' . ($date_from == null ? 'لايوجد' : $date_from) }}
                            {{ ' الى : ' . ($date_to == null ? 'لايوجد' : $date_to) }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table cellpadding="0" cellspacing="0" style="margin-top: 20px">
        <tr class="heading">
            <td style="text-align: center" colspan="3">اجمالى الفواتير خلال الفترة</td>
            <td style="text-align: center" colspan="3">المدفوع خلال الفترة</td>
            <td style="text-align: center" colspan="3">الباقى</td>
        </tr>

        <tr class="item" style="text-align: center">
            <td style="text-align: center" colspan="3">{{ $total }}</td>
            <td style="text-align: center" colspan="3">{{ round($payments_true->sum('value'),2) + round($client_payments_true->sum('value'),2) }}</td>
            <td style="text-align: center" colspan="3">{{ $total_rest  }}</td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" style="margin-top: 20px">
        <tr class="heading">
            <td style="text-align: center" colspan="9">الفواتير</td>
        </tr>
        <tr class="heading">
            <td style="text-align: center">مسلسل</td>
            <td style="text-align: center">كود الفاتورة</td>
            <td style="text-align: center">تاريخ الفاتورة</td>
            <td style="text-align: center">طريقة الدفع</td>
            <td style="text-align: center">اسم المخزن</td>
            <td style="text-align: center">الاجمالى</td>
            <td style="text-align: center">المدفوع</td>
            <td style="text-align: center">المتبقى</td>
            <td style="text-align: center">ملاحظات</td>
        </tr>

        @foreach($bills->where('type' , 'sale')->sortByDesc('date') as $bill)
            <tr class="item" style="text-align: center">
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $bill->code }}</td>
                <td style="text-align: center">{{ $bill->date->format('Y-m-d') }}</td>
                <td style="text-align: center">{{ $bill->method->name ?? null }}</td>
                <td style="text-align: center">{{ $bill->stock->name ?? null }}</td>
                <td style="text-align: center">{{ round($bill->items()->sum('total_price'), 2) }}</td>
                <td style="text-align: center">{{ \App\Models\Payment::where('bill_id' , $bill->id)->where('type' , 'اقساط')->where('status' , 1)->sum('value') }}</td>
                <td style="text-align: center">{{ ($bill->items()->sum('total_price') ?? 0) - (\App\Models\Payment::where('bill_id' , $bill->id)->where('status' , 1)->sum('value') ?? 0) }}</td>
                <td style="text-align: center">{{ $bill->description }}</td>
            </tr>
        @endforeach

        <tr class="item">
            <td colspan="5" style="text-align: center">الإجمالى</td>
            <td style="text-align: center">{{ $total }}</td>
            <td style="text-align: center">{{ round(\App\Models\Payment::whereIn('bill_id' , $bills->pluck('id'))->where('type' , 'اقساط')->where('status' , 1)->sum('value'),2) }}</td>
            <td style="text-align: center">{{ $rest }}</td>
            <td style="text-align: center"></td>
        </tr>
    </table>

    <table class="page-break" cellpadding="0" cellspacing="0" style="margin-top: 20px">
        <tr class="heading">
            <td style="text-align: center" colspan="7">الاقساط لم يتم سدادها</td>
        </tr>
        <tr class="heading">
            <td style="text-align: center">مسلسل</td>
            <td style="text-align: center">تاريخ القسط</td>
            <td style="text-align: center">القيمة</td>
            <td style="text-align: center">رقم الفاتورة</td>
            <td style="text-align: center">تاريخ السداد</td>
            <td style="text-align: center">بنك السداد</td>
            <td style="text-align: center">الوصف</td>
        </tr>

        @foreach($payments_false->sortBy('date') as $payment)
            <tr class="item" style="text-align: center">
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $payment->date->format('Y-m-d') }}</td>
                <td style="text-align: center">{{ $payment->value }}</td>
                <td style="text-align: center">{{ $payment->bill->code ?? null }}</td>
                <td style="text-align: center">{{ $payment->received_date->format('Y-m-d') }}</td>
                <td style="text-align: center">{{ $payment->receivedBank->name ?? null }}</td>
                <td style="text-align: center">{{ $payment->description }}</td>
            </tr>
        @endforeach

        <tr class="item">
            <td colspan="2" style="text-align: center">الإجمالى</td>
            <td style="text-align: center">{{ round($payments_false->sum('value'),2) }}</td>
            <td colspan="4" style="text-align: center"></td>
        </tr>
    </table>

    <table class="page-break" cellpadding="0" cellspacing="0" style="margin-top: 20px">
        <tr class="heading">
            <td style="text-align: center" colspan="5">المدفوعات لم يتم سدادها</td>
        </tr>
        <tr class="heading">
            <td style="text-align: center">مسلسل</td>
            <td style="text-align: center">تاريخ المدفوعة</td>
            <td style="text-align: center">القيمة</td>
            <td style="text-align: center">بنك السداد</td>
            <td style="text-align: center">الوصف</td>
        </tr>

        @foreach($client_payments_false->sortBy('date') as $payment)
            <tr class="item" style="text-align: center">
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $payment->date->format('Y-m-d') }}</td>
                <td style="text-align: center">{{ $payment->value }}</td>
                <td style="text-align: center">{{ $payment->receivedBank->name ?? null }}</td>
                <td style="text-align: center">{{ $payment->description }}</td>
            </tr>
        @endforeach

        <tr class="item">
            <td colspan="2" style="text-align: center">الإجمالى</td>
            <td style="text-align: center">{{ round($client_payments_false->sum('value'),2) }}</td>
            <td colspan="2" style="text-align: center"></td>
        </tr>
    </table>

    <table class="page-break" cellpadding="0" cellspacing="0" style="margin-top: 20px">
        <tr class="heading">
            <td style="text-align: center" colspan="7">الاقساط تم سدادها</td>
        </tr>
        <tr class="heading">
            <td style="text-align: center">مسلسل</td>
            <td style="text-align: center">تاريخ القسط</td>
            <td style="text-align: center">القيمة</td>
            <td style="text-align: center">رقم الفاتورة</td>
            <td style="text-align: center">تاريخ السداد</td>
            <td style="text-align: center">بنك السداد</td>
            <td style="text-align: center">الوصف</td>
        </tr>

        @foreach($payments_true->sortByDesc('date') as $payment)
            <tr class="item" style="text-align: center">
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $payment->date->format('Y-m-d') }}</td>
                <td style="text-align: center">{{ $payment->value }}</td>
                <td style="text-align: center">{{ $payment->bill->code ?? null }}</td>
                <td style="text-align: center">{{ $payment->received_date->format('Y-m-d') }}</td>
                <td style="text-align: center">{{ $payment->receivedBank->name ?? null }}</td>
                <td style="text-align: center">{{ $payment->description }}</td>
            </tr>
        @endforeach

        <tr class="item">
            <td colspan="2" style="text-align: center">الإجمالى</td>
            <td style="text-align: center">{{ round($payments_true->sum('value'),2) }}</td>
            <td colspan="4" style="text-align: center"></td>
        </tr>
    </table>

    <table class="page-break" cellpadding="0" cellspacing="0" style="margin-top: 20px">
        <tr class="heading">
            <td style="text-align: center" colspan="6">المدفوعات تم سدادها</td>
        </tr>
        <tr class="heading">
            <td style="text-align: center">مسلسل</td>
            <td style="text-align: center">تاريخ المدفوعة</td>
            <td style="text-align: center">القيمة</td>
            <td style="text-align: center">تاريخ السداد</td>
            <td style="text-align: center">بنك السداد</td>
            <td style="text-align: center">الوصف</td>
        </tr>

        @foreach($client_payments_true->sortByDesc('date') as $payment)
            <tr class="item" style="text-align: center">
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td style="text-align: center">{{ $payment->date->format('Y-m-d') }}</td>
                <td style="text-align: center">{{ $payment->value }}</td>
                <td style="text-align: center">{{ $payment->transaction_date->format('Y-m-d') }}</td>
                <td style="text-align: center">{{ $payment->receivedBank->name ?? null }}</td>
                <td style="text-align: center">{{ $payment->description }}</td>
            </tr>
        @endforeach

        <tr class="item">
            <td colspan="2" style="text-align: center">الإجمالى</td>
            <td style="text-align: center">{{ round($client_payments_true->sum('value'),2) }}</td>
            <td colspan="3" style="text-align: center"></td>
        </tr>
    </table>
</div>
</body>
</html>
