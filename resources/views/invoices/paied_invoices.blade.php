@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/invoiceDetails.css')}}" rel="stylesheet">

    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('title')
     الفواتير المدفوعة
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/   الفواتير المدفوعة</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

                <!--div-->
                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{session()->get('success')}}</strong>
                    </div>
                    @endif
                    @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{session()->get('error')}}</strong>
                    </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            <div class="col-sm-6 col-md-4 col-xl-3">
                                <a href="invoices/create" class="modal-effect btn btn-outline-primary btn-block"><i class="fas fa-plus"></i> إضافة فاتورة</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">رقم الفاتورة</th>
                                            <th class="border-bottom-0">تاريخ الفاتورة</th>
                                            <th class="border-bottom-0">تاريخ الأستحقاق</th>
                                            <th class="border-bottom-0">المنتج</th>
                                            <th class="border-bottom-0">القسم</th>
                                            <th class="border-bottom-0">الخصم</th>
                                            <th class="border-bottom-0">نسبة الضربية</th>
                                            <th class="border-bottom-0">قيمة الضريبة</th>
                                            <th class="border-bottom-0">الأجمالي</th>
                                            <th class="border-bottom-0">الحالة</th>
                                            <th class="border-bottom-0">ملاحظات</th>
                                            <th class="border-bottom-0">العمليات</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $invoice)
                                        <tr>
                                            <td>{{$counter ++}}</td>
                                            <td>{{ $invoice->invoice_number }}</td>
                                            <td>{{ $invoice->invoice_date }}</td>
                                            <td>{{ $invoice->due_date }}</td>
                                            <td>{{ $invoice->products->product_name }}</td>
                                            <td> <a href="/invoiceDetails/{{$invoice->id}}"> {{ $invoice->section->section_name }} </a> </td>
                                            <td>{{ $invoice->discount }}</td>
                                            <td>{{ $invoice->rate_vat }}</td>
                                            <td>{{ $invoice->value_vat }}</td>
                                            <td>{{ $invoice->total }}</td>
                                            <td>
                                                @if($invoice->value_status == 1)
                                                <span class="text-success">{{ $invoice->status }}</span>
                                                @elseif($invoice->value_status == 2)
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                                @else($invoice->value_status == 1)
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $invoice->note }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-dark"
                                                    data-toggle="dropdown" type="button"> العمليات   <i class="fas fa-caret-down ml-1"></i></button>
                                                    <div class="dropdown-menu tx-13">
                                                        <a class="dropdown-item text-primary" href="{{ url('invoices/edit')}}/{{ $invoice->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                            تعديل
                                                        </a>

                                                        <a class="dropdown-item text-success" href="{{ url('invoices/change_payment')}}/{{ $invoice->id }}">
                                                            <i class="fa-solid fa-bag-shopping"></i>
                                                            تغير حالة الدفع
                                                        </a>

                                                        <a class="dropdown-item text-danger" data-effect="effect-scale"
                                                            data-id="{{ $invoice->id }}" data-delete_type="force_delete" data-toggle="modal"
                                                            href="#delete" title="حذف"><i class="las la-trash"></i>
                                                            حذف
                                                        </a>

                                                        <a class="dropdown-item text-secondary" data-effect="effect-scale"
                                                            data-id="{{ $invoice->id }}" data-delete_type="soft_delete" data-toggle="modal"
                                                            href="#softdelete" title="حذف"><i class="fa-solid fa-box-archive"></i>
                                                            نقل الي الارشيف
                                                        </a>

                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Soft Delete Effects -->
                    <div class="modal" id="softdelete">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{ url('invoices/destroy') }}" method="POST" autocomplete="off">
                                    {{method_field('delete')}}
                                    @csrf
                                    <div class="modal-body">
                                        <p>هل انت متأكد من حذف الفاتورة ؟</p>
                                        <input type="hidden" id="invoice_number" name="invoice_number" >

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">تأكيد</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Soft Delete Effects-->

                    <!-- Modal Delete Invoice Effects -->
                    <div class="modal" id="delete">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title"> نقل الفاتورة الي الارشيف</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{ url('invoices/destroy') }}" method="POST" autocomplete="off">
                                    {{method_field('delete')}}
                                    @csrf
                                    <div class="modal-body">
                                        <p>هل انت متأكد من نقل الفاتورة للأرشيف؟</p>
                                        <input type="hidden" id="invoice_number" name="invoice_number" >
                                        <input type="hidden" id="delete_type" name="delete_type" >

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">تأكيد</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Delete Invoice Effects-->

                </div>
                <!--/div-->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

<script>
    $('#delete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_number = button.data('id')
        var delete_type = button.data('delete_type')
        var modal = $(this)
        modal.find('.modal-body #invoice_number').val(invoice_number);
        modal.find('.modal-body #delete_type').val(delete_type);
    })
</script>
<script>
    $('#softdelete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_number = button.data('id')
        var delete_type = button.data('delete_type')
        var modal = $(this)
        modal.find('.modal-body #invoice_number').val(invoice_number);
        modal.find('.modal-body #delete_type').val(delete_type);
    })
</script>

<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
