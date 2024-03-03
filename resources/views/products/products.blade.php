@extends('layouts.master')
@section('title')
المنتجات
@stop
@section('css')
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
							<h4 class="content-title mb-0 my-auto">المنتجات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                @if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif



@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
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
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									@can('اضافة منتج')
                                <p class="tx-12 tx-gray-500 mb-2"><a class="btn ripple btn-primary" data-target="#modaldemo1" data-toggle="modal" href="">اضافة منتج</a></p>
                                    @endcan
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1" data-page-length="50">
										<thead>
											<tr>
												<th class="wd-15p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0"> اسم المنتج</th>
												<th class="wd-20p border-bottom-0"> اسم القسم</th>
                                                <th class="wd-25p border-bottom-0">ملاحظات </th>
                                                <th class="wd-25p border-bottom-0"> العمليات</th>
											</tr>
										</thead>
										<tbody>
										
					                    <?php $i = 0 ?>
										@foreach($products as $product)
                                         <?php $i++ ?>
											<tr>

												<td>{{$i}}</td>
												<td>{{$product->product_name}}</td>
												<td>{{$product->section->section_name}}</td>
												<td>{{$product->description}}</td>
												<td>
												@can('تعديل منتج')

												<a class="btn ripple btn-primary" data-target="#modaldemo2" data-toggle="modal" href=""
												 data-description="{{$product->description}}" data-product_name="{{$product->product_name}}"
												  data-section_name="{{$product->section->section_name}}"  data-product_id="{{ $product->id }}"> تعديل</a>
												 @endcan
												  @can('حذف منتج')
	  
												<a class="btn ripple btn-danger" data-target="#modaldemo3"
												data-product_id="{{$product->id}}" data-product_name="{{$product->product_name}}" 
												data-toggle="modal" href=""> حذف</a>
												@endcan

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
                			<!-- Basic modal 1 -->
		<div class="modal" id="modaldemo1">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
					<form role="form" action="{{route('products.store')}}"  method="post">
						{{csrf_field()}}
						
						<div class="form-group">
						<label>اسم المنتج</label>
							<input class="form-control" placeholder="يرجي ادخال اسم القسم" id="product_name" name="product_name" type="text" autofocus="">
							
						</div>
                        <div class="form-group">
                        <select class="form-control" name="section_id" id="section_id" aria-label="Default select example">
                       <option selected>-- حدد القسم --</option>
                       @foreach($sections as $section)
                       <option value="{{$section->id}}">{{$section->section_name}}</option>
                       @endforeach
                       </select>
                           </div>
						<div class="form-group">
						<label>ملاحظات</label>
						<textarea name="description" id="description"  class="form-control" cols="30" rows="10"></textarea>
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

									<!-- Basic modal 2-->
									<div class="modal" id="modaldemo2">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title"> تعديل المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
					<form role="form" action="products/update"  method="post" autocomplete="off">
						{{method_field('patch')}}
						{{csrf_field()}}

						<div class="form-group">
						<label>اسم المنتج</label>
						<input type="hidden" name="product_id" id="product_id" value="">
							<input class="form-control"  id="product_name" name="product_name" type="text" autofocus="">
							
						</div>
						<div class="form-group">
						<label> القسم</label>

                        <select class="form-control" name="section_name" id="section_name" aria-label="Default select example">
                       @foreach($sections as $section)
                       <option {{$section->id}}>{{$section->section_name}}</option>
                       @endforeach
                       </select>
                           </div>
						<div class="form-group">
						<label>ملاحظات</label>
						<textarea name="description" id="description"  class="form-control" cols="30" rows="10"></textarea>
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
							<div class="modal" id="modaldemo3">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title"> حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
					<form role="form" action="products/destroy"  method="post" >
					{{method_field('delete')}}

						{{csrf_field()}}
						
						<div class="form-group">
						<h6 class="modal-title">  هل انت متاكد من حذف المنتج ؟</h6>

							<input class="form-control"  id="product_id" name="product_id" type="hidden" autofocus="">
							<input class="form-control" readonly id="product_name" name="product_name" type="text" autofocus="">

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
<script>
    $('#modaldemo2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
		var product_id = button.data('product_id')
		var product_name = button.data('product_name')
        var section_name = button.data('section_name')
        var description = button.data('description')
        var modal = $(this)
		modal.find('.modal-body #product_id').val(product_id);
		modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
    })
	$('#modaldemo3').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
		var product_id = button.data('product_id')
		var product_name = button.data('product_name')
        var modal = $(this)
		modal.find('.modal-body #product_id').val(product_id);
		modal.find('.modal-body #product_name').val(product_name);
    })
</script>
@endsection