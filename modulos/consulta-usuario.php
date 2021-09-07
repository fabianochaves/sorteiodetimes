<?php
/* CONSULTA DE USUÁRIO */
date_default_timezone_set('America/Sao_Paulo');

?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['nome_sistema']; ?> | Consulta de Usuário</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico" />

    <?php include('processos/head-consultas/headers-consulta.php') ?>

</head>

<body>
    <?php include('processos/consulta-usuario/modals.php') ?>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include("menu.php"); ?>

        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title" style="height: 95px;">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-albums icon-gradient bg-mean-fruit"></i>
                            </div>
                            <div>Consulta de Usuário
                                <div class="page-title-subheading">
                                    CONSULTA
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="main-card col-md-12 mb-3 card">
                    <div class="card-body">

                        <center>
                            <div id="resultado_grid" style="overflow:auto; width: 100%"></div>
                        </center>
                    </div>
                </div>

                <script src="js/consultas/consulta-usuario/acoes-filtro.js"></script>
