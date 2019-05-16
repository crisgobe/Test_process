@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section('main-content')

    @if (session('message'))
        <div class="alert alert-success text-green">
            {{ session('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="../orders/all">
                <div class="visual">
                    <i class="fa fa-cogs"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ count($actives) }}">0</span>
                    </div>
                    <div class="desc"> Procesos Activos </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="../orders/all">
                <div class="visual">
                    <i class="fa fa-close"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ count($canceled) }}">0</span>
                    </div>
                    <div class="desc"> Procesos Cancelados </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="../orders/all">
                <div class="visual">
                    <i class="fa fa-check"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ count($finished) }}">0</span>
                    </div>
                    <div class="desc"> Procesos Finalizados </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="../orders/all">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ count($orders) }}"></span>
                    </div>
                    <div class="desc"> Total Procesos </div>
                </div>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Procesos</span>
                        <span class="caption-helper">/ Cantidad de Procesos por mes</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="site_statistics_loading">
                        <img src="../assets/global/img/loading.gif" alt="loading" />
                    </div>
                    <div id="site_statistics_content" class="display-none">
                        <div id="site_statistics" class="chart"> </div>
                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-red-sunglo hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Finalizados</span>
                        <span class="caption-helper">/ Finalizados por mes</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="site_activities_loading">
                        <img src="../assets/global/img/loading.gif" alt="loading" />
                    </div>
                    <div id="site_activities_content" class="display-none">
                        <div id="site_activities" class="chart"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type='hidden' id='array_date_quantity' value='<?php $dq = json_encode($date_quantity); echo $dq; ?>'>
    <input type='hidden' id='array_quantity_finished' value='<?php $dqf = json_encode($quantity_fin); echo $dqf; ?>'>
@endsection

@section('scripts')

@parent
    <script src="../assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="{{ asset('js/home/home.js') }}"></script>
@stop