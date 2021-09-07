<?php
/* CADASTRO DE USUÁRIO */
include("Connections/connpdo.php");

$pasta_gravacao = "cadastro-usuario";
$rotina_gravacao = "cadastro-usuario-gravar.php";

?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['nome_sistema']; ?> | Cadastro de Usuário</title>

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
                        <div>Cadastro de Usuário
                            <div class="page-title-subheading">
                                Cadastro
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card col-md-12">
                <div class="card-body">
                    <h5 class="card-title col-md-12 col text-center">Cadastro de Usuário</h5>
                    <div class="col-md-12 col text-left">
                        <form class="needs-validation offset-md-12 col-md-12 " name="formulario" id="formulario" method="POST" novalidate>
                            <br>
                            <input type="hidden" name="pasta_gravacao" id="pasta_gravacao" value="<?php echo $pasta_gravacao; ?>" />
                            <input type="hidden" name="rotina_gravacao" id="rotina_gravacao" value="<?php echo $rotina_gravacao; ?>" />

                            <div class="form-row">
                                <div class="col-md-4">
                                    <label class="label_titulos">Nome</label>
                                    <input autocomplete="off" type="text" name="nome" id="nome" style="height: 34px;" class="form-control obrigatorios somenteLetras" tabindex="1" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Nome!
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="label_titulos">E-mail</label>
                                    <input autocomplete="off" type="email" name="email" id="email" style="height: 34px;" class="form-control obrigatorios" tabindex="2" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o E-mail!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Perfil</label>
                                    <select data-placeholder="Escolha o Perfil..." name="perfil" id="perfil" class="form-control obrigatorios chosen-select" tabindex="3" required>
                                        <option selected value="">Escolha o Perfil...</option>
                                        <?php
                                        $query_perfil = $conn->prepare("SELECT * FROM perfis WHERE status_perfil = 1 AND id_perfil != 1000");

                                        try {
                                            $query_perfil->execute();
                                        } catch (PDOException $e) {
                                            $e->getMessage();
                                        }

                                        while ($row_perfil = $query_perfil->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row_perfil['id_perfil'] . '">' . utf8_encode($row_perfil['nome_perfil']) . '</option>';
                                        }
                                        ?>

                                    </select>

                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Perfil!
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Nível</label>
                                    <select data-placeholder="Escolha..." name="nivel" id="nivel" class="form-control obrigatorios chosen-select" tabindex="4" required>
                                        <option selected value="">Escolha...</option>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
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
                                        Preencha o Nível!
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Goleiro</label>
                                    <select data-placeholder="Escolha..." name="goleiro" id="goleiro" class="form-control obrigatorios chosen-select" tabindex="5" required>
                                        <option selected value="">Escolha...</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Informação!
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="label_titulos">Telefone</label>
                                    <input autocomplete="off" type="tel" name="telefone" id="telefone" style="height: 34px;" class="form-control obrigatorios phone" tabindex="6" onKeyPress="return somenteNumeros(event);" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Telefone!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="label_titulos">Login</label>
                                    <input autocomplete="off" type="text" name="login" id="login" style="height: 34px;" class="form-control obrigatorios somenteTextoSemCaracteresEspeciais" tabindex="7" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Login!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="label_titulos">Senha</label>
                                    <input autocomplete="new-password" type="password" name="senha" id="senha" style="height: 34px;" class="form-control obrigatorios" tabindex="8" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Senha!
                                    </div>
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