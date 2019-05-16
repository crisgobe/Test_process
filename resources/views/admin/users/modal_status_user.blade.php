<div class="modal fade" id="modal_status_user" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Cambiar el estado del usuario
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <form action="change_status/{{ $user['id'] }}" method="post" id="form_status_user">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <?php
                                $active   = '';
                                $inactive = '';

                                if ($user['status_id'] == 1) {
                                    $active = 'checked';
                                }
                                else {
                                    $inactive = 'checked';
                                }
                            ?>

                            <div class="input-group">
                                <div class="icheck-list">
                                    <label>
                                        <input type="radio" name="status_id" class="icheck" {{ $active }} value="1">
                                        Activo
                                    </label>
                                    <label>
                                        <input type="radio" name="status_id" class="icheck" {{ $inactive }} value="2">
                                        Inactivo
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn green btn-block" id="change_status_user">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>