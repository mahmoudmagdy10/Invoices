@extends('layouts.master')
@section('css')
    <style>
        @media print {

            #print_button,
            .main-header,
            .my-auto,
            .main-footer {
                display: none !important;
            }
        }
    </style>
@endsection
@section('title')
    معاينة طباعة الفاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة
                    الفاتوره</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                <div class="card card-invoice">
                    <div class="card-body" id="print">
                        <div class="invoice-header">
                            <h1 class="invoice-title">الفاتورة</h1>
                            <div class="billed-from">
                                <h6>BootstrapDash, Inc.</h6>
                                <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                    Tel No: 324 445-4544<br>
                                    Email: youremail@companyname.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>Juan Dela Cruz</h6>
                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                        Tel No: 324 445-4544<br>
                                        Email: youremail@companyname.com</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">معلومات الفاتورة</label>
                                <p class="invoice-info-row bg-light text-dark"><span>رقم الفاتورة</span>
                                    <span class="bg-light text-dark">{{ $invoice->invoice_number }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الأصدار</span>
                                    <span>{{ $invoice->invoice_date }}</span>
                                </p>
                                <p class="invoice-info-row bg-light text-dark"><span>تاريخ الأستحقاق</span>
                                    <span class="bg-light text-dark">{{ $invoice->due_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>القسم</span>
                                    <span>{{ $invoice->section->section_name }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-20p">المنتج</th>
                                        <th class="tx-center"></th>
                                        <th class="tx-center">مبلغ التحصيل</th>
                                        <th class="tx-right">مبلغ العمولة</th>
                                        <th class="tx-right">الأجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <td>{{ $i }}</td>
                                        <td>{{ $invoice->products->product_name }}</td>
                                        <td class="tx-12"></td>
                                        <td class="tx-center">{{ number_format($invoice->amount_collection, 2) }}</td>
                                        <td class="tx-right">{{ number_format($invoice->amount_commission, 2) }}</td>
                                        @php
                                            $total = $invoice->amount_commission + $invoice->amount_collection;
                                        @endphp
                                        <td class="tx-right">{{ number_format($total, 2) }}</td>
                                    </tr>
                                    <hr class="mg-b-40">
                                    <tr>
                                        <td class="valign-middle" colspan="2" rowspan="4">
                                            <div class="invoice-notes">
                                                <label class="main-content-label tx-13">ملاحظات</label>
                                                <p class="text-dark">{{ $invoice->note }}</p>
                                            </div><!-- invoice-notes -->
                                        </td>
                                        <td class="tx-right bg-secondary text-white">الأجمالي</td>
                                        <td class="tx-right bg-secondary text-white" colspan="2">
                                            {{ number_format($total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">نسبة الضريبه ({{ $invoice->rate_vat }})</td>
                                        <td class="tx-right" colspan="2">{{ $invoice->value_vat }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right bg-secondary text-white">الخصم</td>
                                        <td class="tx-right bg-secondary text-white" colspan="2">
                                            {{ $invoice->discount }}</td>
                                    </tr>
                                    <tr>
                                        @php
                                            $total_val = $total + $invoice->value_vat + $invoice->discount;
                                        @endphp
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">الأجمالي شامل الضريبة</td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-primary tx-bold">${{ number_format($total_val, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">

                        <button id="print_button" class="btn btn-danger float-left mt-3 mr-2" onclick="printDiv()">
                            <i class="mdi mdi-printer ml-1"></i>
                            طباعة
                        </button>


                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <script type="text/javascript">
        function printDiv() {
            var printContent = document.getElementById('print').innerHML;
            var originalContent = document.body.innerHML;
            document.body.innerHML = printContent;
            window.print();
            document.body.innerHML = originalContent;
            window.reload();

        }
    </script>
@endsection
