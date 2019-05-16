<div class="modal fade" id="modal_new_user" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
                        <div class="portlet light portlet-fit portlet-form ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-user font-green"></i>
                                    <span class="caption-subject font-green sbold uppercase">Agregar nuevo Usuario</span>
                                </div>
                                <!-- <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div> -->
                            </div>
                            <div class="portlet-body">
                                <form action="#" id="form_new_user" autocomplete="off">
                                    <div class="form-body">
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                        	<div class="input-group">
	                                            <input type="text" class="form-control" name="name_user" id="form_control_name_user">
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
	                                            <input type="text" class="form-control" name="email" id="form_control_email">
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
	                                            <input type="password" class="form-control" name="password" id="form_control_password">
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
				                                    <option value="{{ $user_type->id }}">{{ $user_type->type }}</option>
				                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal" aria-label="Close">
                                                    Cerrar
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn green btn-block btn-flat" id="save_new_user" data-loading-text="Guardando <i class='fa fa-spinner fa-spin'></i>">
                                                    Guardar Usuario
                                                </button>
                                            </div>
                                        </div>
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