<?php
/* ALTERAÇÃO DE SENHA */
include("Connections/connpdo.php");

?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['nome_empresa']; ?> | Alterar Senha</title>
    
    <?php include("processos/head-padrao/headers.php"); ?>

</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include("menu.php"); ?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title" style="height: 95px;">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-user icon-gradient bg-mean-fruit"></i>
                            </div>
                            <div>Alterar Senha
                            </div>
                        </div>
                    </div>
                </div>


                <div class="main-card mb-3 card col-md-6 offset-md-3">

                    <div class="card-body">
                        <h5 class="card-title col-md-12 col text-center">Alterar Senha
                        </h5>

                        <div class="col-md-12 col text-left">
                            <form class="needs-validation offset-md-12 col-md-12 " name="formulario" id="formulario" method="POST" novalidate>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-8 offset-md-2">
                                        <label class="label_titulos">Senha Atual</label>
                                        <input autocomplete="off" type="password" name="senha_atual" id="senha_atual" style="height: 34px;" class="form-control obrigatorios" value="" required />
                                        <div class="invalid-feedback">
                                            Preencha a Senha Atual!
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-8 offset-md-2">
                                        <label class="label_titulos">Senha Nova</label>
                                        <input autocomplete="off" type="password" name="senha_nova" id="senha_nova" style="height: 34px;" class="form-control obrigatorios" value="" required />
                                        <div class="invalid-feedback">
                                            Preencha a Senha Nova!
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-8 offset-md-2">
                                        <label class="label_titulos">Confirmação da Senha</label>
                                        <input autocomplete="off" type="password" name="senha_nova_confirma" id="senha_nova_confirma" style="height: 34px;" class="form-control obrigatorios" value="" required />
                                        <div class="invalid-feedback">
                                            Preencha a Senha Nova!
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6 offset-md-3">

                                        <center><img id="aguarde" src="<?php echo URL::getBase(); ?>assets/images/gif/loading.gif" style="width: 120px; height: 120px; display:none;" /></center>

                                        <button class="btn btn-success col-md-12" id="btn_confirmar" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i>
                                            Confirmar</button>

                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-8 offset-md-2">
                                        <center>
                                            <div class="alert alert-danger" role="alert" id="erro" style="display:none;">
                                                <center><b><span id="msg_erro"></span></b></center>
                                            </div>

                                            <div class="alert alert-success" role="alert" id="sucesso" style="display:none;">
                                                <center><b><span id="msg_sucesso"></span></b>
                                                </center>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <script type="text/javascript" src="js/alterarsenha/scripts.js"></script>
        <script type="text/javascript" src="js/somenteNumeros.js"></script>
        <script type="text/javascript" src="js/somenteLetras.js"></script>

        <script>
            $(document).ready(function() {

                $('.valor').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
            });
        </script>