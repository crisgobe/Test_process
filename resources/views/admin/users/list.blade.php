@extends('layouts.app')

@section('htmlheader_title')
	Users
@endsection

<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

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
                                <i class="fa fa-users font-green"></i>
                                <span class="font-green bold uppercase">Usuarios</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-default" href="javascript:;" id="open_modal_new_user" title="Nuevo Usuario">
                                    <i class="fa fa-plus"></i>
                                </a>
                                <div class="btn-group">
                                    <a class="btn btn-circle btn-default" href="javascript:;" data-toggle="dropdown" title="Crear Archivo">
                                        <i class="icon-printer"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="{{ url('users/pdf_all_users') }}" target="_blank"> Descargar PDF </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('users/excel_all_users') }}" target="_blank"> Descargar Excel </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="table_users_list">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th width="15%">Nombre</th>
			                				<th width="30%">Correo Electrónico</th>
			                        		<th width="15%">Tipo Usuario</th>
			                        		<th width="15%">Estado</th>
			                        		<th width="10%">Detalles</th>
                                        </tr>
                                        <tr role="row" class="filter">
                                            <td data-column="0">
                                                <input type="text" class="form-control form_filter_user input-sm" name="user_name" id="col0_filter_user">
                                            </td>
                                            <td data-column="1">
                                                <input type="text" class="form-control form_filter_user input-sm" name="user_email" id="col1_filter_user">
                                            </td>
                                            <td data-column="2">
                                                <select class="form-control form_filter_user input-sm" name="user_types_id" id="col2_filter_user">
                                                    <option value="">-- Todas --</option>

                                                    @foreach ($user_types as $user_type)
                                                    	<option value="{{ $user_type->id }}">{{ $user_type->type }}</option>
                                                    @endforeach

                                                </select>
                                            </td>
                                            <td data-column="3">
                                                <select class="form-control form_filter_user input-sm" name="user_status" id="col3_filter_user">
                                                    <option value="">-- Todos --</option>

                                                	@foreach ($user_status as $status)
                                                    	<option value="{{ $status->id }}">{{ $status->status }}</option>
                                                    @endforeach

                                                </select>
                                            </td>
                                            <td>
                                            	<button class="btn red btn-outline btn-block btn-sm" id="reset_table_list_users">
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

	@include('admin.users.modal_new_user')

@endsection
@section('scripts')

@parent
	<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
	<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
	<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>    
	<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
	<script src="../assets/pages/scripts/table-datatables-ajax.min.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/form-validation-md.min.js" type="text/javascript"></script>

	<script src="{{ asset('js/users/list.js') }}"></script>
	<script src="{{ asset('js/users/new.js') }}"></script>
    <script src="{{ asset('js/form_validate.js') }}"></script>
@stop