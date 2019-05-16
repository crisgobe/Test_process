<!DOCTYPE html>

<html lang="en">

    @include('layouts.auth.headauth')
    <!-- END HEAD -->

    <body class=" login">
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" style="background-image:url(../assets/pages/img/login/bg1.jpg)">
                        <img class="login-logo" src="../assets/pages/img/login/logo.png" />
                    </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                    <div class="login-content">
                        <h1>
                        	TRACKING System
                        </h1>
                        <p>
                        	Sistema para seguimiento de ventas.
                        </p>

                        <!-- BEGIN FORM LOGIN -->
                        <form action="{{ url('/login') }}" class="login-form" method="post">
                            {{ csrf_field() }}

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul class="text_error">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>Ingrese su usuario y su contraseña.</span>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="email" autocomplete="off" placeholder="Usuario" name="email" id="email" required/>
                                </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Contraseña" name="password" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <!-- <div class="forgot-password">
                                        <a href="javascript:;" id="forget-password" class="forget-password">
                                        	Olvidó su contraseña?
                                        </a>
                                    </div> -->
                                    <button class="btn green" type="submit" id="user_login">
                                    	Entrar
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM LOGIN -->

                        <!-- BEGIN FORGOT PASSWORD FORM -->
                        <form class="forget-form" action="javascript:;" method="post" style="display: none;">
                            <h3 class="font-green">
                            	Olvidó su contraseña?
                            </h3>
                            <p>
                            	Ingrese su Correo electrónico para restaurar su contraseña.
                            </p>
                            <div class="form-group">
                                <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Correo electrónico" name="email" /> </div>
                            <div class="form-actions">
                                <button type="button" id="back-btn" class="btn green btn-outline">
                                	Atras
                                </button>
                                <button type="submit" class="btn btn-success uppercase pull-right">
                                	Enviar
                                </button>
                            </div>
                        </form>
                        <!-- END FORGOT PASSWORD FORM -->
                        
                    </div>
                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset">&nbsp;</div>
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
                                    <p>Copyright &copy; CM SOLUCIONES INTEGRALES S.A.S. 2019</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END : LOGIN PAGE 5-1 -->

        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        @include('layouts.auth.scriptsauth')
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>