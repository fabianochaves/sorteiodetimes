<?php
/* CONSULTA DE CONFIRMAÇÕES */
date_default_timezone_set('America/Sao_Paulo');
?>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['nome_sistema']; ?> | Consulta de Confirmações</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico" />

    <?php include('processos/head-consultas/headers-consulta.php') ?>

</head>
<body>
    <?php include('processos/consulta-confirmacao/modals.php') ?>

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
                            <div>Consulta de Confirmações
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
                                <div class="col-md-5 offset-md-4">
                                    <label class="label_titulos" for="validationCustom01">Partida:</label>
                                    <select data-placeholder="Escolha a Partida..." id="filtro" name="filtro" class="form-control obrigatorios chosen-select" required>
                                        <option value="">Escolha...</option>
                                        <?php
                                        $query = $conn->prepare("SELECT * FROM partidas p 
                                        INNER JOIN locais l ON (l.id_local = p.local_partida)
                                        WHERE status_partida = 1");

                                        try {
                                            $query->execute();
                                        } catch (PDOException $e) {
                                            $e->getMessage();
                                        }

                                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row['id_partida'].'">' . $row['nome_local'] . " | " . date("d/m/Y", strtotime($row['data_partida'])) . " | " . $row['hora_partida'] .'</option>';
                                        }
                                        ?>

                                    </select>

                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Escolha a Partida!
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <center>
                                        <button type="button" id="btn_filtro" class="btn btn-success">Filtrar <i class="fa fa-search" aria-hidden="true"></i></button>
                                    </center>
                                </div>
                            </div>
                        </form>
                        <center><img id="aguarde" src="<?php echo URL::getBase(); ?>assets/images/gif/aguarde.gif" style="width: 120px; height: 120px; display:none;" /></center>
                        <center>
                            <div id="resultado_grid" style="overflow:auto; width: 100%"></div>
                        </center>
                    </div>
                </div>
                <script src="js/consultas/consulta-confirmacao/acoes-filtro.js"></script>
