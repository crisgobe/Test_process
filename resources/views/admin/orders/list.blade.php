@extends('layouts.app')

@section('htmlheader_title')
	Orders
@endsection

@section('main-content')

	@if (session('message'))
        <div class="alert alert-success text-green">
            {{ session('message') }}
        </div>
    @endif

    @if (session('message_error'))
        <div class="alert alert-danger">
            {{ session('message_error') }}
        </div>
    @endif

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
                <div class="box-body">
                	<div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-clipboard font-green"></i>
                                <span class="font-green bold uppercase">Procesos</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="table_orders_list">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th width="10%">Número</th>
			                        		<th width="15%">Ciudad</th>
			                        		<th width="15%">Estado</th>
                                            <th width="10%">Creación</th>
                                            <th width="5%">Días</th>
			                        		<th width="10%">Detalles</th>
                                        </tr>
                                        <tr role="row" class="filter">
                                            <td data-column="0">
                                                <input type="text" class="form-control form_filter_order input-sm" name="order_number" id="col0_filter_order">
                                            </td>
                                            <td data-column="1">
                                                <select class="form-control form_filter_order input-sm" name="order_status" id="col1_filter_order">
                                                    <option value="">-- Todas --</option>

                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                                                    @endforeach

                                                </select>
                                            </td>
                                            <td data-column="2">
                                                <select class="form-control form_filter_order input-sm" name="order_status" id="col2_filter_order">
                                                    <option value="">-- Todos --</option>

                                                	@foreach ($order_status as $status)
                                                        <option value="{{ $status->id }}">{{ $status->status }}</option>
                                                    @endforeach

                                                </select>
                                            </td>
                                            <td data-column="3">
                                                <input type="text" class="form-control form_filter_order input-sm" name="order_customer" id="col3_filter_order">
                                            </td>
                                            <td data-column="4">
                                                <input type="text" class="form-control form_filter_order input-sm" name="order_customer" id="col4_filter_order">
                                            </td>
                                            <td>
                                            	<button class="btn red btn-outline btn-block btn-sm" id="reset_table_list_orders">
                                            		<!-- <i class="icon-reload"></i> Filtros -->
                                                    Limpiar
                                            	</button>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                        </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	

@endsection
@section('scripts')

@parent
	<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
	<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
	<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
	<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
	<script src="../assets/pages/scripts/table-datatables-ajax.min.js" type="text/javascript"></script>
	<script src="{{ asset('js/orders/list.js') }}"></script>
@stop