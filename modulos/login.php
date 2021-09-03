<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Sistema de Partidas - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="plugins/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="css/login/util.css">
    <link rel="stylesheet" type="text/css" href="css/login/main.css">

</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" name="form-login" id="form-login" method="POST">
                    <span class="login100-form-title p-b-5">
                        Autenticação
                    </span>
                    <span class="login100-form-title p-b-28">
                        <img src="assets/images/logo_orig.png" />
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Prencha seu Login">
                        <input class="input100" type="text" name="usuario" id="usuario">
                        <span class="focus-input100" data-placeholder="Login"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Digite a Senha">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="senha" id="senha">
                        <span class="focus-input100" data-placeholder="Senha"></span>
                    </div>
                    <center><img id="aguarde_login" src="assets/images/gif/loading.gif"
                            style="width: 100px; height: 100px; display: none;" /></center>

                    <div class="alert alert-danger" role="alert" id="alert_erro" style="display:none;">
                        <center><b><span id="msg_erro"></span></b></center>
                    </div>

                    <div class="alert alert-danger" role="alert" id="erro_conexao" style="display:none;">
                        <center><b>Não foi possível conectar ao Servidor!</b></center>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button id="btn_entrar" class="login100-form-btn">
                                Entrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="plugins/jquery/jquery-3.2.1.min.js"></script>
    <script src="js/login/login.js"></script>
    <script src="plugins/animsition/js/animsition.min.js"></script>
    <script src="plugins/bootstrap/js/popper.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/select2/select2.min.js"></script>
    <script src="plugins/daterangepicker/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="js/login/main.js"></script>
    <!--===============================================================================================-->

</body>

</html>