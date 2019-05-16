@extends('layouts.app')

@section('htmlheader_title')
    New Order
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
        <div class="col-md-12">
            <div class="btn-group btn-group-xs btn-group-solid">
                <a href="../orders" type="button" class="btn green btn-outline">
                    <i class="fa fa-reply"></i>
                    Volver al listado de Procesos
                </a>
            </div>
        </div>
    </div>
    <div>&nbsp;</div>
    <div class="row">
        <div class="portlet light ">
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_0">
                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption">
                                    Proceso n° {{ $order_number }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <div class="input-group col-md-12">
                                                <textarea class="form-control" id="order_comment" rows="3"></textarea>
                                                <label for="order_comment">
                                                    Descripción
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="form-group">
                                            <label for="form_control_cities_id">
                                                Departamentos
                                            </label>
                                            <select class="form-control select2-multiple" name="departments_id" id="departments_id">
                                                <option value=""></option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="form-group">
                                            <label for="form_control_cities_id">
                                                Ciudades
                                            </label>
                                            <select class="form-control select2-multiple" name="cities_id" id="cities_id">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <ul class="pager">
                                    <li class="previous"></li>
                                    <li class="next">
                                        <a href="javascript:;" class="btn blue" id="create_order" data-loading-text="Creando Proceso <i class='fa fa-spinner fa-spin'></i>">
                                            <i class="fa fa-check"></i>
                                            Crear Proceso
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END TAB PORTLET-->
        <!-- <div class="col-md-12">
            <div class="tabbable-line boxless tabbable-reversed">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_0" id="btn_tab_0" data-toggle="tab"> Cliente </a>
                    </li>
                    <li>
                        <a href="#tab_1" id="btn_tab_1" data-toggle="tab"> Productos </a>
                    </li>
                    <li>
                        <a href="#tab_2" id="btn_tab_2" data-toggle="tab"> Resumen </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_0">
                        
                    </div>
                    <div class="tab-pane" id="tab_1">
                        
                    </div>
                    <div class="tab-pane" id="tab_2">
                        
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

@include('admin.orders.modal_comments_order')

@endsection
@section('scripts')

@parent
    <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/form-validation-md.min.js" type="text/javascript"></script>

    <script src="{{ asset('js/orders/new.js') }}"></script>
    <script src="{{ asset('js/customers/new.js') }}"></script>
    <script src="{{ asset('js/form_validate.js') }}" type="text/javascript"></script>
@stop