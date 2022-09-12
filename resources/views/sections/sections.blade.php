@extends('layouts.master')
@section('css')
@endsection
@section('title')
الأقسام
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الأعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
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

                        @can('اضافة قسم')
                        <div class="card-header pb-0">
                            <div class="col-sm-6 col-md-4 col-xl-3">
                                <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#addsection">إضافة قسم</a>
                            </div>
                        </div>
                        @endcan

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">اسم القسم</th>
                                            <th class="border-bottom-0">الوصف</th>
                                            <th class="border-bottom-0">العمليات</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sections as $section)
                                        <tr>
                                            <td>{{$counter ++}}</td>
                                            <td>{{$section->section_name}}</td>
                                            <td>{{$section->description}}</td>
                                            <td>
                                                @can('تعديل قسم')
                                                <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                        data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}"
                                                        data-description="{{ $section->description }}" data-toggle="modal" href="#editmodel"
                                                        title="تعديل"><i class="las la-pen"></i>
                                                </a>
                                                @endcan

                                                @can('حذف قسم')
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}" data-toggle="modal"
                                                    href="#deletemodel" title="حذف"><i class="las la-trash"></i>
                                                </a>
                                                @endcan

                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- Modal effects -->
                    <div class="modal" id="addsection">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">إضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('sections.store')}}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="section">اسم القسم</label>
                                            <input type="text" class="form-control" id="section" name="section_name" placeholder="ادخل اسم القسم">
                                            @error('section_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="descripe">الملاحظات</label>
                                            <textarea class="form-control" id="descripe" name="description" placeholder="ادخل ملاحظات القسم"></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">إضافة</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal effects-->

                    <!-- Modal edit effects -->
                    <div class="modal" id="editmodel">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">تعديل القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="sections/update" method="POST" autocomplete="off">
                                    {{method_field('patch')}}
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="id" name="id" value="" >
                                            <label for="section_name">اسم القسم</label>
                                            <input type="text" class="form-control" id="section_name" name="section_name" placeholder="ادخل اسم القسم" >
                                        </div>
                                        <div class="form-group">
                                            <label for="description">الملاحظات</label>
                                            <textarea class="form-control" id="description" name="description" placeholder="ادخل ملاحظات القسم" ></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">تعديل</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal edit effects-->

                    <!-- Modal delete effects -->
                    <div class="modal" id="deletemodel">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="sections/destroy" method="POST" autocomplete="off">
                                    {{method_field('delete')}}
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="id" name="id" value="" >
                                            <label for="section_name">اسم القسم</label>
                                            <input type="text" class="form-control" id="section_name" name="section_name" readOnly>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">تأكيد</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal delete effects-->
                </div>
                <!--/div-->
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
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

<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
    $('#editmodel').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
    })
</script>
<script>
    $('#deletemodel').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
    })
</script>

@endsection
