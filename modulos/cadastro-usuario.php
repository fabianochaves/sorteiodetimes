<?php
/* CADASTRO DE USUÁRIO */
include("Connections/connpdo.php");

?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['nome_sistema']; ?> | Cadastro de Usuário</title>

    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
    <link href="./css/checkbox.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script type="text/javascript" src="js/cpf.js"></script>
    <script type="text/javascript" src="js/maskfone.js"></script>

    <script type="text/javascript" src="js/validarform.js"></script>

    <!-- select chosen dinâmico !--->

    <link rel="stylesheet" href="css/bootstrap-chosen.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <script src="js/chosen_modif.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js">
    </script>

    <script type="text/javascript" src="js/priceFormatAjustado.js"></script>

    <script src="js/valida_cpf_cnpj.js"></script>
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
                            <div class="form-row">
                                <div class="col-md-5">
                                    <label class="label_titulos">Nome</label>
                                    <input autocomplete="off" type="text" name="nome" id="nome" style="height: 34px;" class="form-control obrigatorios somenteLetras" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Nome!
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="label_titulos">CPF</label>
                                    <input autocomplete="off" type="tel" name="cpf" id="cpf" style="height: 34px;" class="form-control obrigatorios cpf cpf_cnpj" length="20" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o CPF!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="label_titulos">Nascimento</label>
                                    <input autocomplete="off" type="text" name="nascimento" id="nascimento" style="height: 34px; text-align: center" class="form-control obrigatorios dataDMY" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Nascimento!
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Empresa Padrão</label>

                                    <select data-placeholder="Escolha..." name="empresa" id="empresa" class="form-control obrigatorios chosen-select" tabindex="2" required>
                                        <option selected value="">Escolha...</option>
                                        <?php
                                        $query_empresa = $conn->prepare("SELECT * FROM empresas WHERE status_empresa = 1");

                                        try {
                                            $query_empresa->execute();
                                        } catch (PDOException $e) {
                                            $e->getMessage();
                                        }

                                        while ($row_empresa = $query_empresa->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row_empresa['id_empresa'] . '">' . $row_empresa['nome_empresa'] . '</option>';
                                        }
                                        ?>

                                    </select>

                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Empresa!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Perfil</label>

                                    <select data-placeholder="Escolha o Perfil..." name="perfil" id="perfil" class="form-control obrigatorios chosen-select" tabindex="2" required>
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
                                <div class="col-md-3">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Região</label>

                                    <select data-placeholder="Escolha..." name="regiao" id="regiao" class="form-control obrigatorios chosen-select" tabindex="2" required>
                                        <option selected value="">Escolha...</option>
                                        <option value="999">Nenhuma Região</option>
                                        <?php
                                        $busca_regiao = $conn->prepare("SELECT * FROM regioes WHERE status_regiao = 1");

                                        try {
                                            $busca_regiao->execute();
                                        } catch (PDOException $e) {
                                            $e->getMessage();
                                        }

                                        while ($row_regiao = $busca_regiao->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row_regiao['id_regiao'] . '">' . utf8_encode($row_regiao['nome_regiao']) . '</option>';
                                        }
                                        ?>
                                    </select>

                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Região!
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="validationCustom01"></label>
                                    <label class="label_titulos">Tabela Padrão</label>

                                    <select data-placeholder="Escolha..." name="tabela_padrao" id="tabela_padrao" class="form-control obrigatorios chosen-select" tabindex="2" required>
                                        <option selected value="">Escolha...</option>
                                        <option value="1">Tabela 1</option>
                                        <option value="2">Tabela 2</option>
                                        <option value="3">Tabela 3</option>
                                        <option value="4">Tabela 4</option>
                                    </select>

                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Tabela!
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label class="label_titulos">Comissão</label>
                                    <input maxlength="5" type="tel" onkeypress="return somenteNumeros(event)" class="form-control obrigatorios valor" style="height: 34px;" name="comissao" id="comissao" value="" required />
                                    <div class="invalid-feedback">
                                        Preencha a Comissão!
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="label_titulos">Módulos Permitidos</label>
                                    <input type="tel" onkeypress="return somenteNumeros(event)" class="form-control obrigatorios" style="height: 34px;" name="modulos_permitidos" id="modulos_permitidos" value="" required />
                                    <div class="invalid-feedback">
                                        Preencha Módulos Permitidos!
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="label_titulos">CEP</label>
                                    <input autocomplete="off" type="tel" name="cep" id="cep" style="height: 34px;" class="form-control obrigatorios cep" value="" onKeyPress="return somenteNumeros(event);" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o CEP!
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="label_titulos">Rua</label>
                                    <input autocomplete="off" type="text" name="rua" id="rua" style="height: 34px;" class="form-control obrigatorios" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Rua!
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="label_titulos">Número</label>
                                    <input autocomplete="off" type="tel" name="numero" id="numero" style="height: 34px;" class="form-control obrigatorios cep" value="" onKeyPress="return somenteNumeros(event);" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Número!
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label class="label_titulos">Complemento</label>
                                    <input autocomplete="off" type="text" name="complemento" id="complemento" style="height: 34px;" class="form-control" value="" />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Complemento!
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="label_titulos">Bairro</label>
                                    <input autocomplete="off" type="text" name="bairro" id="bairro" style="height: 34px;" class="form-control obrigatorios" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Bairro!
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="label_titulos">Cidade</label>
                                    <input autocomplete="off" type="text" name="cidade" id="cidade" style="height: 34px;" class="form-control obrigatorios" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha a Cidade!
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label class="label_titulos">Estado</label>
                                    <input autocomplete="off" type="text" name="estado" id="estado" style="height: 34px;" class="form-control obrigatorios" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Estado!
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="label_titulos">Telefone 1</label>
                                    <input autocomplete="off" type="tel" name="telefone1" id="telefone1" style="height: 34px;" class="form-control obrigatorios phone" value="" onKeyPress="return somenteNumeros(event);" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Telefone 1!
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="label_titulos">Telefone 2</label>
                                    <input autocomplete="off" type="tel" name="telefone2" id="telefone2" style="height: 34px;" class="form-control phone" value="" onKeyPress="return somenteNumeros(event);" />
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="label_titulos">E-mail</label>
                                    <input autocomplete="off" type="email" name="email_user" id="email_user" style="height: 34px;" class="form-control obrigatorios" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o E-mail!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="label_titulos">Login</label>
                                    <input autocomplete="off" type="text" name="login_user" id="login_user" style="height: 34px;" class="form-control obrigatorios somenteTextoSemCaracteresEspeciais" value="" required />
                                    <div class="valid-feedback">
                                        Ok!
                                    </div>
                                    <div class="invalid-feedback">
                                        Preencha o Login!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="label_titulos">Senha</label>
                                    <input autocomplete="new-password" type="password" name="senha_user" id="senha_user" style="height: 34px;" class="form-control obrigatorios" value="" required />
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

                                    <center><img id="aguarde" src="<?php echo URL::getBase(); ?>assets/images/gif/loading.gif" style="width: 120px; height: 120px; display:none;" /></center>

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

<script type="text/javascript" src="js/cadastro-usuario/scripts.js"></script>
<script type="text/javascript" src="js/loadMasks.js"></script>


<script>
    $(document).ready(function() {

        $('.valor').priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
</script>