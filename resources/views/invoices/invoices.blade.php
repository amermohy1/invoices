@extends('layouts.master')
@section('title')
 الفواتير
@stop
@section('css')
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@endsection
@section('content')
				<!-- row -->
				<div class="row">
				@if (session()->has('Status_Update'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Status_Update') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
				@if (session()->has('delete_invoices'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }

        </script>
    @endif

					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									@can('اضافة فاتورة')
                                <p class="tx-12 tx-gray-500 mb-2"> <a href="invoices/create" class="btn btn-primary mt-3 mb-0">اضافة فاتوره</a></p>
                                    @endcan
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead >
											<tr>
												<th class="wd-15p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0">رقم الفاتورة</th>
												<th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
												<th class="wd-15p border-bottom-0">القسم</th>
												<th class="wd-10p border-bottom-0">المنتج</th>
												<th class="wd-25p border-bottom-0">تاريخ الاستحقاق</th>
                                                <th class="wd-25p border-bottom-0">الخصم</th>
												<th class="wd-25p border-bottom-0">نسبة الضريبة </th>
												<th class="wd-25p border-bottom-0"> قيمة الضريبة</th>
												<th class="wd-25p border-bottom-0"> الحالة</th>
                                                <th class="wd-25p border-bottom-0"> الاجمالي</th>
                                                <th class="wd-25p border-bottom-0">ملاحظات </th>
                                                <th class="wd-25p border-bottom-0"> العمليات</th>


											</tr>
										</thead>
										<tbody>
										
					                    <?php $i = 0 ?>
										@foreach($invoices as $invoice)
										<?php $i++ ?>
											<tr>
												<td>{{$i}}</td>
												<td>{{$invoice->invoice_number}}</td>
												<td>{{$invoice->invoice_date}}</td>
												<td>
													<a href="{{url('InvoicesDetails')}}/{{$invoice->id}}">{{$invoice->section->section_name}}</a>
												</td>
												<td>{{$invoice->product}}</td>
												<td>{{$invoice->due_date}}</td>
												<td>{{$invoice->discount}}</td>
												<td>{{$invoice->rate_vat}}</td>
							 					<td>{{$invoice->value_vat}}</td>
												<td>
                                                   @if ($invoice->value_status == 1)
                                                      <span class="text-success">{{ $invoice->status }}</span>
                                                   @elseif($invoice->value_status == 2)
                                                      <span class="text-danger">{{ $invoice->status }}</span>
                                                   @else
                                                      <span class="text-warning">{{ $invoice->status }}</span>
                                                    @endif
                                                </td>
												<td>{{ $invoice->total }}</td>
												<td>{{ $invoice->note }}</td>
												<td>											
				                            	<div class="dropdown">
	<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
	data-toggle="dropdown" id="dropdownMenuButton" type="button">العمليات <i class="fas fa-caret-down ml-1"></i></button>
	<div  class="dropdown-menu tx-13">
	@can('تعديل الفاتورة')

		<a class=" dropdown-item btn  btn-primary" href="{{url('edit_invoice')}}/{{$invoice->id}}">تعديل</a>
		@endcan

		@can('حذف الفاتورة')

		<a class="dropdown-item btn  btn-primary" data-target="#delete_invoice" data-invoice_id="{{$invoice->id}}" 
		data-toggle="modal" href=""><i class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp; حذف</a>	
			@endcan
			@can('تغير حالة الدفع')

			<a class="dropdown-item" href="{{ URL::route('Status_show', [$invoice->id]) }}">تغير حالة الدفع</a>
			@endcan
			@can('ارشفة الفاتورة')

		<a class="dropdown-item btn  btn-primary" data-target="#invoices_achive" data-invoice_id="{{$invoice->id}}" 
		data-toggle="modal" href=""><i class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp; ارشفة الفاتورة</a>
		@endcan

		@can('طباعةالفاتورة')
		<a class="dropdown-item" href="print_invoice/{{$invoice->id}}"> <i class="text-success fas fa-print"></i>&nbsp;&nbsp; طباعة الفاتورة</a>
		@endcan

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
					
					<!--/div-->

					
					
				

					
					
				</div>
					<!--/div-->
				</div>
										<!-- Basic modal 3-->
			<div class="modal" id="delete_invoice">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title"> حذف الفاتورة </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
					<form role="form" action="{{route('invoices.destroy','test')}}"  method="post" >
					{{method_field('delete')}}
						{{csrf_field()}}

						<div class="form-group">
						<h6 class="modal-title">  هل انت متاكد من حذف الفاتورة ؟</h6>
							<input class="form-control" value="" id="invoice_id" name="invoice_id" type="hidden" autofocus="">
						</div>
						
						<div class="modal-footer">
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
						<button class="btn ripple btn-primary" type="submit">تاكيد </button>
					</div>
					
				</form>
					</div>
		
				</div>
			</div>
		</div>
		<!-- End Basic modal -->
								<!-- Basic modal 3-->
		<div class="modal" id="invoices_achive">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title"> ارشفة الفاتورة </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
					<form role="form" action="archive"  method="post" >
						{{csrf_field()}}

						<div class="form-group">
						<h6 class="modal-title">  هل انت متاكد من ارشفة الفاتورة ؟</h6>
							<input class="form-control" value="" id="invoice_id" name="invoice_id" type="hidden" >
							<input class="form-control" value="2" id="id_page" name="id_page" type="hidden" >

						</div>
						
						<div class="modal-footer">
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
						<button class="btn ripple btn-primary" type="submit">تاكيد </button>
					</div>
					
				</form>
					</div>
		
				</div>
			</div>
		</div>
		<!-- End Basic modal -->
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
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
<script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>
	 <script>
        $('#invoices_achive').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>
@endsection