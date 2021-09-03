<?php
/* CONSULTA DE USUÁRIO */
date_default_timezone_set('America/Sao_Paulo');

$data_atual = date("d/m/Y");

?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['nome_empresa']; ?> | Consulta de Usuário</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
    <link href="./css/checkbox.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="js/consultas/scriptEditar.js"></script>
    <script src="js/somenteLetras.js"></script>
    <script src="js/somenteNumeros.js"></script>
    <script src="js/cpf.js"></script>
    <script src="js/maskfone.js"></script>


    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>


    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript" src="./js/validarform.js"></script>

    <!--- datatables !--->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>


    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedcolumns/3.3.1/css/fixedColumns.bootstrap4.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js">
    </script>

    <style>
        th {
            font-size: 13px;
        }

        td {
            font-size: 13px;
        }
    </style>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js">
    </script>

    <link rel="stylesheet" href="css/bootstrap-chosen.css" />

    <!--- <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script> !--->
    <script src="js/chosen_modif.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript" src="js/priceFormatAjustado.js"></script>

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
                        <form name="form_filtro" id="form_filtro" class="needs-validation" action="" method="POST" novalidate>
                            <div class="form-row">
                                <div class="col-md-5 offset-md-1">
                                    <label class="label_titulos" for="validationCustom01">Empresa:</label>
                                    <select data-placeholder="Escolha a Empresa..." id="filtro_empresa" name="filtro_empresa" class="form-control obrigatorios chosen-select" tabindex="2" required>
                                        <option value="0_Todas">Todas</option>
                                        <?php
                                        $query_empresa = $conn->prepare("SELECT * FROM empresas WHERE status_empresa = 1");

                                        try {
                                            $query_empresa->execute();
                                        } catch (PDOException $e) {
                                            $e->getMessage();
                                        }

                                        while ($row_empresa = $query_empresa->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row_empresa['id_empresa'] . '_' . $row_empresa['nome_empresa'] . '">' . $row_empresa['nome_empresa'] . '</option>';
                                        }
                                        ?>

                                    </select>

                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Escolha a Empresa!
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="label_titulos" for="validationCustom01">Perfil:</label>
                                    <select data-placeholder="Escolha o Perfil..." id="filtro_perfil" name="filtro_perfil" class="form-control obrigatorios chosen-select" tabindex="2" required>
                                        <option value="0">Todos</option>
                                        <?php
                                        $query_perfil = $conn->prepare(
                                            "SELECT * FROM 
                                                perfis 
                                                WHERE 
                                                status_perfil = 1 
                                                AND 
                                                id_perfil != 1000"
                                        );

                                        try {
                                            $query_perfil->execute();
                                        } catch (PDOException $e) {
                                            $e->getMessage();
                                        }

                                        while ($row_perfil = $query_perfil->fetch(PDO::FETCH_ASSOC)) {
                                            $idPerfil = $row_perfil['id_perfil'];
                                            $nomePerfil = utf8_encode($row_perfil['nome_perfil']);

                                            echo '<option value="' . $idPerfil . '">' . $nomePerfil . '</option>';
                                        }
                                        ?>

                                    </select>

                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Escolha o Perfil!
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <center>
                                        <button type="button" id="btn_filtro" class="btn btn-success" style="width: 73px;">Filtrar <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                    </center>
                                </div>
                            </div>
                        </form>
                        <center><img id="aguarde" src="<?php echo URL::getBase(); ?>assets/images/gif/aguarde.gif" style="width: 120px; height: 120px; display:none;" /></center>
                        <center>
                            <div id="resultado_grid" style="overflow:auto; width: 65vw"></div>
                        </center>
                    </div>
                </div>
                <script src="js/plugins/moment/moment-2.24.0.min.js"></script>
                <script src="js/plugins/moment/moment-with-locales-2.24.0.min.js"></script>

                <script src="js/consultas/consulta-usuario/acoes-filtro.js"></script>
                <script src="js/consultas/consulta-usuario/acoes-editar.js"></script>