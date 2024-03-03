@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				
@endsection
@section('content')
<br><br>
				<!-- row -->
				<div class="row">

                <div class="d-md-flex">
	<div class="">
		<div class="panel panel-primary tabs-style-4">
			<div class="tab-menu-heading">
				<div class="tabs-menu ">
                @if (session()->has('delete'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
					<!-- Tabs -->
					<ul class="nav panel-tabs">
						<li><a href="#tab21" class="active" data-toggle="tab"><i class="fa fa-cube" ></i> معلومات الفاتورة  </a></li>
						<li><a href="#tab23" data-toggle="tab"><i class="fa fa-cogs"></i> حالات الفاتورة</a></li>
						<li><a href="#tab24" data-toggle="tab"><i class="fa fa-tasks"></i> المرفقات</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="tabs-style-4">
		<div class="panel-body tabs-menu-body">
			<div class="tab-content">
				<div class="tab-pane active" id="tab21">
					<p> رقم الفاتورة : {{$invoices->invoice_number}}</p>
					<p>تاريخ الفاتورة :  {{$invoices->invoice_date}}</p>
					<p >القسم : {{$invoices->section->section_name}}</p>
                    <p> المنتج :  {{$invoices->product}}</p>
                    <p>تاريخ الاستحقاق :  {{$invoices->due_date}}</p>

                    <p> مبلغ التحصيل : {{$invoices->Amount_collection}}</p>
                    <p>مبلغ العمولة : {{$invoices->Amount_Commission}}</p>
                    <p>الخصم : {{$invoices->discount}}</p>
                    <p>نسبة الضريبة :  {{$invoices->rate_vat}}</p>
                    <p>الحالة :  @if ($invoices->value_status == 1)
                                                      <span class="text-white badge badge-pill badge-success">{{ $invoices->status }}</span>
                                                   @elseif($invoices->value_status == 2)
                                                      <span class="text-white badge badge-pill badge-danger">{{ $invoices->status }}</span>
                                                   @else
                                                      <span class="text-warning">{{ $invoices->status }}</span>
                                                    @endif</p>
                    <p>الاجمالي : {{$invoices->total}}</p>
                    <p>  ملاحظات : {{$invoices->note}}</p>

				</div>
				
				<div class="tab-pane" id="tab23">
                    @foreach($details as $i)
                <p> رقم الفاتورة : {{$i->invoice_number}}</p>
					<p>تاريخ الدفع :  {{$i->Payment_Date}}</p>
					<p >القسم : {{$invoices->section->section_name}}</p>
                    <p> المنتج :  {{$i->product}}</p>

                    <p>الحالة :  @if($i->Value_Status == 1)
                                                      <span class="text-white badge badge-pill badge-success">{{ $i->Status }}</span>
                                                   @elseif($i->Value_Status == 2)
                                                      <span class="text-white badge badge-pill badge-danger">{{ $i->Status }}</span>
                                                   @else
                                                      <span class="text-warning">{{ $i->Status }}</span>
                                                    @endif</p>
                    <p>  ملاحظات : {{$i->note}}</p>
                    <p>  تاريخ الاضافة والوقت : {{$i->created_at}}</p>
                    <p>  المسخدم : {{$i->user}}</p>

				 @endforeach
				</div>
				<div class="tab-pane" id="tab24">
                  	                            @can('اضافة مرفق')
												<a class="btn ripple btn-primary" data-target="#modaldemo15"
												  data-toggle="modal" href=""> اضافة مرفق</a>
                                                @endcan
								 <div class="card-body">
								<div class="table-responsive">

                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">										<thead>
											<tr class="text-dark">
												<th scope="col">م</th>
												<th scope="col">اسم الملف </th>
												<th scope="col"> قام بالاضافة</th>
												<th scope="col">تاريخ الاضافة</th>
												<th scope="col">العمليات</th>
												

											</tr>
										</thead>
										<tbody>
										
					                    <?php $i = 0 ?>
                                        @foreach($attachments as $x)
										<?php $i++ ?>
											<tr>
												<td>{{$i}}</td>
												<td>{{$x->file_name}}</td>
												<td>{{$x->Created_by}}</td>
												
												<td>{{$x->created_at}}</td>
																							
				                            	
                                                <td colspan="2">

<a class="btn btn-outline-success btn-sm"
    href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $x->file_name }}"
    role="button"><i class="fas fa-eye"></i>&nbsp;
    عرض</a>

<a class="btn btn-outline-info btn-sm"
    href="{{ url('download') }}/{{ $x->invoice_number }}/{{ $x->file_name }}"
    role="button"><i
        class="fas fa-download"></i>&nbsp;
    تحميل</a>

	@can('حذف المرفق')
    <button class="btn btn-outline-danger btn-sm"
        data-toggle="modal"
        data-file_name="{{ $x->file_name }}"
        data-invoice_number="{{ $x->invoice_number }}"
        data-id_file="{{ $x->id }}"
        data-target="#delete_file">حذف</button>
    @endcan

</td> 
											</tr>
                                        @endforeach
										</tbody>
									</table>
								</div>
							</div>
                
				</div>
			</div>
		</div>
	</div>
</div>

				</div>
				<!-- row closed -->
                              			<!-- Basic modal 1 -->
		<div class="modal" id="delete_file">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
					</div>
					<div class="modal-body">
					<form role="form" action="{{route('delete_file')}}"  method="post">
						{{csrf_field()}}
						
						<div class="form-group">
						<label> </label>
                        <h6 class="modal-title"> هل انت متاكد من حذف المرفق ؟</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>

							<input class="form-control"  id="id_file" name="id_file" type="hidden" autofocus="">
                            <input class="form-control"  id="file_name" name="file_name" type="hidden" autofocus="">
							<input class="form-control"  id="invoice_number" name="invoice_number" type="hidden" autofocus="">

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
                			<!-- Basic modal5 -->
		<div class="modal" id="modaldemo15">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة مرفق</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                    <div class="card-body">
                                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
					  <form method="post" action="{{ url('/InvoiceAttachments') }}" enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile"
                                                                    name="file_name" required>
                                                                <input type="hidden" id="customFile" name="invoice_number"
                                                                    value="{{ $invoices->invoice_number }}">
                                                                <input type="hidden" id="invoice_id" name="invoice_id"
                                                                    value="{{ $invoices->id }}">
                                                                <label class="custom-file-label" for="customFile">حدد
                                                                    المرفق</label>
                                                            </div><br><br>
                                                            <button type="submit" class="btn btn-primary  "
                                                                name="uploadedFile">تاكيد</button>
                                                        </form>
					</div>
		
				</div>
			</div>
		</div>
		<!-- End Basic modal -->
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
<script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

    </script>
@endsection