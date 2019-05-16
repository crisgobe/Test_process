@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('main-content')
    <link href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<section class="content">

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

        <div id="general_message_orders"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group btn-group-xs btn-group-solid">
                    <a href="{{ $url_back }}" type="button" class="btn green btn-outline">
                        <i class="fa fa-reply"></i>
                        Volver al listado de procesos
                    </a>
                </div>
            </div>
        </div>
        <br>
    	
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-clipboard"></i>
                            Proceso N° {{ $order->number }}
                        </div>
                        <div class="tools">
                            @if ($download != '')
                                Descargar <a href="../storage/{{ $download }}" target="_blank" class="fa fa-cloud-download"> </a>
                            @endif
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption font-green-sharp">
                                                            <i class="icon-speech font-green-sharp"></i>
                                                            <span class="caption-subject bold uppercase"> Comentarios </span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="scroller" style="height:300px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">

                                                            @foreach ($steps->reverse() as $step)
                                                                <?php $date_modify = new \DateTime( $step->updated_at ) ?>

                                                                <div class="note note-{{ $step->status->color }}" style="color: grey">
                                                                    <p style="font-size: 20px"></p>
                                                                    <span style="font-size: 10px">({{ $step->user->userTypes->type }}: {{ $step->user->name }})</span>
                                                                    <br>

                                                                    <span style="font-size: 10px">{{ $date_modify->format( "d/M/Y h:i a" ) }}</span>
                                                                    <!-- <p>{{ $step->status->status }}</p> -->
                                                                    <br><br>

                                                                    <p> {{ $step->comment }} </p>
                                                                </div>

                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END SAMPLE TABLE PORTLET-->
                                </div>
                            </div>
                            @if ($show == 'yes')
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="next_phase_order" action="change_phase_order" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="orders_id" value="{{ $order->id }}">
                                            <input type="hidden" name="phase_step" id="phase_step" value="{{ $steps->last()->steps_id }}">
                                            <input type="hidden" name="status_step" id="status_step">
                                            <input type="hidden" name="date_start_end" id="date_start_end">
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="comments_step" name="comments" placeholder="Comentarios"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                @if ($calendar == 'yes')
                                                    <label>
                                                        Seleccione la fecha de Inicio y la fecha de Finalizado
                                                    </label>
                                                    <input type="text" name="date_range" id="date_range">
                                                @elseif ($file == 'yes')
                                                    <input type="file" class="form-control" name="file_process" accept=".jpeg , .jpg , .doc , .docx , .pdf" required>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    @if ($finalize == 'no')
                                        <div class="col-md-4">
                                            <div class="form-actions">
                                                <center>
                                                    <button type="button" id="cancel_order" class="btn btn-danger">
                                                        <i class="fa fa-close"></i> 
                                                        Cancelar Proceso
                                                    </button>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-actions">
                                                <center>
                                                    <button type="button" id="pause_order" class="btn btn-warning">
                                                        <i class="fa fa-pause"></i> 
                                                        En Proceso
                                                    </button>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-actions">
                                                <center>
                                                    <button type="button" id="approve_order" class="btn btn-success">
                                                        <i class="fa fa-check"></i> 
                                                        Aprobar y Continuar
                                                    </button>
                                                </center>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <div class="form-actions">
                                                <center>
                                                    <button type="button" id="approve_order" class="btn blue">
                                                        <i class="fa fa-check"></i> 
                                                        Finalizar
                                                    </button>
                                                </center>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	
@endsection

@section('scripts')

@parent
    <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

    <script src="{{ asset('js/orders/detail.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="{{ asset('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/form-icheck.min.js') }}" type="text/javascript"></script>
@stop