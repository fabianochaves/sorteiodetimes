<?php
/* CADASTRO DE PARTIDA */
include("Connections/connpdo.php");
$pasta_gravacao = "cadastro-partida";
$rotina_gravacao = "cadastro-partida-gravar.php";
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['nome_sistema']; ?> | Cadastro de Partida</title>

    <?php include("processos/head-padrao/headers.php"); ?>

    <script type="text/javascript" src="js/gravacao-padrao/scripts.js"></script>

</head>

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
                        <div>Cadastro de Partida
                            <div class="page-title-subheading">
                                Cadastro
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card col-md-12">
                <div class="card-body">
                    <h5 class="card-title col-md-12 col text-center">Cadastro de Partida</h5>

                    <div class="col-md-12 col text-left">
                        <form class="needs-validation offset-md-12 col-md-12 " name="formulario" id="formulario" method="POST" novalidate>
                            <br>
                            <input type="hidden" name="pasta_gravacao" id="pasta_gravacao" value="<?php echo $pasta_gravacao; ?>" />
                            <input type="hidden" name="rotina_gravacao" id="rotina_gravacao" value="<?php echo $rotina_gravacao; ?>" />

                            <div class="form-row">
                                <div class="col-md-3">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Local</label>
                                    <select data-placeholder="Escolha o Local..." name="local" id="local" class="form-control obrigatorios chosen-select" tabindex="1" required>
                                        <option selected value="">Escolha o Local...</option>
                                        <?php
                                        $query_local = $conn->prepare("SELECT * FROM locais WHERE status_local = 1");

                                        try {
                                            $query_local->execute();
                                        } catch (PDOException $e) {
                                            $e->getMessage();
                                        }

                                        while ($row_local = $query_local->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row_local['id_local'] . '">' . $row_local['nome_local'] . '</option>';
                                        }
                                        ?>

                                    </select>

                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Local!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Jogadores por Time</label>
                                    <select data-placeholder="Escolha..." name="nro_jogadores" id="nro_jogadores" class="form-control obrigatorios chosen-select" tabindex="2" required>
                                        <option selected value="">Escolha...</option>
                                        <?php
                                        for ($i = 5; $i <= 11; $i++) {
                                        ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Nº de Jogadores!
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="label_titulos">Data</label>
                                    <input autocomplete="off" type="tel" name="data_partida" id="data_partida" style="height: 34px;" class="form-control obrigatorios dataDMY" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Data!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="label_titulos">Hora</label>
                                    <input autocomplete="off" type="text" name="hora" id="hora" style="height: 34px;" class="form-control obrigatorios horario" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Hora!
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-row">
                                <div class="col-md-8 offset-md-2">
                                    <center>
                                        <div class="alert alert-danger" role="alert" id="erro" style="display:none;">
                                            <center><b><span id="msg_erro"></span></b></center>
                                        </div>

                                        <div class="alert alert-success" role="alert" id="sucesso" style="display:none;">
                                            <center><b>Cadastro <span id="cod_gerado"></span> salvo com Sucesso!</b>
                                            </center>
                                        </div>
                                    </center>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 offset-md-4">
                                    <img id="aguarde" src="assets/images/gif/loading.gif" style="width: 120px; height: 120px; display:none;" />
                                    <button class="btn btn-success col-md-12" id="btn_cadastrar" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i> Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>