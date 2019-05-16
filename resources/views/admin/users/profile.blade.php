@extends('layouts.app')

@section('htmlheader_title')
    User
@endsection

@section('main-content')
    <link href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    <section class="content">
        <input type="hidden" id="user_id" value="{{ $user['id'] }}">

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

        @if (session('message_standar'))
            <div class="alert alert-info">
                {{ session('message_standar') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group btn-group-xs btn-group-solid">
                    <a href="../users" type="button" class="btn green btn-outline">
                        <i class="fa fa-reply"></i>
                        Volver al listado de usuarios
                    </a>
                </div>
            </div>
        </div>
        <br>
        
        <div class="row">
            <div class="col-md-12">
                <div class="profile-sidebar">
                    <div class="portlet light profile-sidebar-portlet ">
                        <div class="profile-userpic">
                            <img src="{{ asset('assets/pages/media/no_image.png') }}" class="img-responsive" alt="">
                        </div>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name user_name_label">
                                {{ $user['name'] }}
                            </div>
                            <div class="profile-usertitle-job user_position_label">
                                {{ $user->userTypes->type }}
                            </div>
                        </div>
                        <div class="profile-userbuttons">
                            <button type="button" class="btn btn-circle {{ $status_color }} btn-sm" id="open_modal_status_user">{{ $user->status->status }}</button>
                        </div>
                        <div class="profile-usermenu"></div>
                    </div>
                </div>
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">
                                            Perfíl de Usuario | <small class="user_name_label">{{ $user['name'] }}</small>
                                        </span>
                                    </div>
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">
                                                Perfíl
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_1">
                                            <form action="#" id="form_edit_user" autocomplete="off">
                                                <div class="form-body">
                                                    <div class="form-group form-md-line-input form-md-floating-label">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="name" id="form_control_name" value="{{ $user['name'] }}">
                                                            <label for="form_control_name">
                                                                Nombre
                                                            </label>
                                                            <span class="help-block">Ingrese el nombre del usuario</span>
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input form-md-floating-label">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="email" id="form_control_email" value="{{ $user['email'] }}">
                                                            <label for="form_control_email">
                                                                Correo Electrónico
                                                            </label>
                                                            <span class="help-block">Ingrese el correo electrónico del usuario</span>
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-at"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-md-line-input form-md-floating-label">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" name="password_p" id="form_control_password">
                                                            <label for="form_control_password">
                                                                Contraseña
                                                            </label>
                                                            <span class="help-block">Ingrese la contraseña del usuario</span>
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-lock"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="form_control_types_id">
                                                            Tipo de Usuario
                                                        </label>
                                                        <select class="form-control select2-multiple" name="user_types_id" id="user_types_id">
                                                            <option value=""></option>
                                                            @foreach ($user_types as $user_type)
                                                                @if ($user_type->id == $user['user_types_id'])
                                                                    <option value="{{ $user_type->id }}" selected>{{ $user_type->type }}</option>
                                                                @else
                                                                    <option value="{{ $user_type->id }}">{{ $user_type->type }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="margiv-top-10">
                                                    <button type="button" class="btn green btn-flat" id="save_edit_user" data-loading-text="Guardando Cambios <i class='fa fa-spinner fa-spin'></i>">
                                                        Guardar Cambios
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.users.modal_status_user')
@endsection

@section('scripts')

@parent
    <script src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/form-icheck.min.js') }}" type="text/javascript"></script>

    <script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="../assets/pages/scripts/form-validation-md.min.js" type="text/javascript"></script>

    <script src="{{ asset('js/users/profile.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/form_validate.js') }}" type="text/javascript"></script>
@stop