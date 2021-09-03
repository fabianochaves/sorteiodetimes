<?php
include("../../Connections/connpdo.php");
date_default_timezone_set('America/Sao_Paulo');

$id = $_POST['id'];

$busca = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = $id");

try 
{
    $busca->execute();
} 
catch (PDOException $e) 
{
    $e->getMessage();
}

$row = $busca->fetch(PDO::FETCH_ASSOC);

$nome = utf8_encode($row['nome_usuario']);
$login = utf8_encode($row['login_usuario']);
$cpf = $row['cpf_usuario'];

$nasc_exp = explode('-', $row['nascimento_usuario']);
$nascimento = $nasc_exp[2].'/'.$nasc_exp[1].'/'.$nasc_exp[0];

$empresa = $row['empresa_usuario'];
$perfil = $row['perfil_usuario'];
$tabelaPadrao = $row['tabela_usuario'];
$comissao = str_replace(".",",", $row['comissao_usuario']);
$modulosPermitidos = $row['modulos_perm_usuario'];
$regiao = $row['regiao_usuario'];

$cep = $row['cep_usuario'];
$rua = utf8_encode($row['rua_usuario']);
$numero = utf8_encode($row['nro_usuario']);
$complemento = utf8_encode($row['comp_usuario']);
$bairro = utf8_encode($row['bairro_usuario']);
$cidade = utf8_encode($row['cidade_usuario']);
$estado = utf8_encode($row['estado_usuario']);

$email = utf8_encode($row['email_usuario']);
$telefone1 = $row['telefone1_usuario'];
$telefone2 = $row['telefone2_usuario'];

$status = $row['status_usuario'];
?>

<form class="needs-validation offset-md-12 col-md-12 " name="formulario" id="formulario" method="POST" novalidate>
    <br>
    <div class="form-row">
        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id; ?>" />
        <div class="col-md-3">
            <label class="label_titulos">Login</label>
            <input autocomplete="off" type="text" name="login_user" id="login_user" style="height: 34px;"
            class="form-control obrigatorios somenteTextoSemCaracteresEspeciais" value="<?php echo $login; ?>"
            required />
        </div>
        <div class="col-md-2">
            <center>
                <label for="validationCustom02">Trocar Senha</label>
                <label class="custom-control custom-checkbox">
                    <input type="hidden" id="ckb_trocarSenha" name="ckb_trocarSenha" value="0" />
                    <input type="checkbox" id="trocarSenha" name="trocarSenha" class="custom-control-input" />
                    <span class="custom-control-indicator"></span>
                </label>
            </center>
        </div>
        <div id="div_nova_senha" class="col-md-3" style="display: none;">
            <label class="label_titulos">Nova Senha</label>
            <input autocomplete="off" type="text" name="nova_senha" id="nova_senha" style="height: 34px;"
            class="form-control obrigatorioNovaSenha" value="" required />
            <div class="valid-feedback">
                Ok!
            </div>
            <div class="invalid-feedback">
                Preencha a Nova Senha!
            </div>
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="col-md-5">
            <label class="label_titulos">Nome</label>
            <input autocomplete="off" type="text" name="nome" id="nome" style="height: 34px;"
            class="form-control obrigatorios somenteLetras" value="<?php echo $nome; ?>" required />
            <div class="valid-feedback">
                Ok!
            </div>
            <div class="invalid-feedback">
                Preencha o Nome!
            </div>
        </div>
        <div class="col-md-4">
            <label class="label_titulos">CPF</label>
            <input autocomplete="off" type="tel" name="cpf" id="cpf" style="height: 34px;"
            class="form-control obrigatorios cpf cpf_cnpj" length="20" value="<?php echo $cpf; ?>" required />
            <div class="valid-feedback">
                Ok!
            </div>
            <div class="invalid-feedback">
                Preencha o CPF!
            </div>
        </div>
        <div class="col-md-3">
            <label class="label_titulos">Nascimento</label>
            <input autocomplete="off" type="text" name="nascimento" id="nascimento"
            style="height: 34px; text-align: center" class="form-control obrigatorios dataDMY"
            value="<?php echo $nascimento; ?>" required />
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

            <select data-placeholder="Escolha..." name="empresa" id="empresa"
            class="form-control obrigatorios chosen-select" tabindex="2" required>
            <option value="">Escolha...</option>
            <?php
            $query_empresa = $conn->prepare("SELECT * FROM empresas WHERE status_empresa = 1");

            try 
            {
                $query_empresa->execute();
            } 
            catch (PDOException $e) 
            {
                $e->getMessage();
            }

            while($row_empresa = $query_empresa->fetch(PDO::FETCH_ASSOC))
            {
                $selected = $empresa != $row_empresa['id_empresa'] ? '' : 'selected';                        
                echo '<option '.$selected.' value="'.$row_empresa['id_empresa'].'">'.$row_empresa['nome_empresa'].'</option>';
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

        <select data-placeholder="Escolha o Perfil..." name="perfil" id="perfil"
        class="form-control obrigatorios chosen-select" tabindex="2" required>
        <option selected value="">Escolha o Perfil...</option>
        <?php
        $query_perfil = $conn->prepare("SELECT * FROM perfis WHERE status_perfil = 1 AND id_perfil != 1000");

        try 
        {
            $query_perfil->execute();
        } 
        catch (PDOException $e) 
        {
            $e->getMessage();
        }

        while($row_perfil = $query_perfil->fetch(PDO::FETCH_ASSOC))
        {
            $selected = $perfil != $row_perfil['id_perfil'] ? '' : 'selected';
            echo '<option '.$selected.' value="'.$row_perfil['id_perfil'].'">'.$row_perfil['nome_perfil'].'</option>';
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
    <label class="label_titulos">Tabela Padrão</label>

    <select data-placeholder="Escolha..." name="tabela_padrao" id="tabela_padrao"
    class="form-control obrigatorios chosen-select" tabindex="2" required>
    <option value="">Escolha...</option>
    <option <?php if ($tabelaPadrao == '1') echo 'selected'; ?> value="1">Tabela 1</option>
    <option <?php if ($tabelaPadrao == '2') echo 'selected'; ?> value="2">Tabela 2</option>
    <option <?php if ($tabelaPadrao == '3') echo 'selected'; ?> value="3">Tabela 3</option>
    <option <?php if ($tabelaPadrao == '4') echo 'selected'; ?> value="4">Tabela 4</option>
</select>

<div class="valid-feedback">
    Ok!
</div>
<div class="invalid-feedback">
    Preencha a Tabela!
</div>
</div>
<div class="col-md-2">
    <label class="label_titulos">Comissão</label>
    <input maxlength="5" type="tel" onkeypress="return somenteNumeros(event)"
    class="form-control obrigatorios valor" style="height: 34px;"
    name="comissao" id="comissao" value="<?php echo $comissao; ?>" required />
    <div class="invalid-feedback">
        Preencha a Comissão!
    </div>
</div>
</div>
<br>
<div class="form-row">
    <div class="col-md-2">
        <label class="label_titulos">Módulos Permitidos</label>
        <input type="tel" onkeypress="return somenteNumeros(event)" class="form-control obrigatorios"
        style="height: 34px;" name="modulos_permitidos" id="modulos_permitidos"
        value="<?php echo $modulosPermitidos; ?>" required />
        <div class="invalid-feedback">
            Preencha Módulos Permitidos!
        </div>
    </div>
    <div class="col-md-3">
        <label for="validationCustom01"></label>
        <label class="label_titulos">Região</label>

        <?php
        $busca_regiao = $conn->prepare("SELECT * FROM regioes WHERE status_regiao = 1");

        try 
        {
            $busca_regiao->execute();
        } 
        catch (PDOException $e) 
        {
            $e->getMessage();
        }



        ?>

        <select data-placeholder="Escolha..." name="regiao" id="regiao"
        class="form-control obrigatorios chosen-select" tabindex="2" required>
        <option selected value="">Escolha...</option>
    
        <?php


        while($row_regiao = $busca_regiao->fetch(PDO::FETCH_ASSOC))
        {
            if($row_regiao['id_regiao'] == $regiao)
            {
                $selected_regiao = "selected";
            }
            else
            {
                $selected_regiao = "";
            }

            ?>
                <option <?php echo $selected_regiao; ?>  value="<?php echo $row_regiao['id_regiao']; ?>"><?php echo utf8_encode($row_regiao['nome_regiao']); ?></option>
            <?php

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
    <label class="label_titulos">CEP</label>
    <input autocomplete="off" type="tel" name="cep" id="cep" style="height: 34px;"
    class="form-control obrigatorios cep" value="<?php echo $cep; ?>"
    onKeyPress="return somenteNumeros(event);" required />
    <div class="valid-feedback">
        Ok!
    </div>
    <div class="invalid-feedback">
        Preencha o CEP!
    </div>
</div>
<div class="col-md-3">
    <label class="label_titulos">Rua</label>
    <input autocomplete="off" type="text" name="rua" id="rua" style="height: 34px;"
    class="form-control obrigatorios" value="<?php echo $rua; ?>" required />
    <div class="valid-feedback">
        Ok!
    </div>
    <div class="invalid-feedback">
        Preencha a Rua!
    </div>
</div>
<div class="col-md-2">
    <label class="label_titulos">Número</label>
    <input autocomplete="off" type="tel" name="numero" id="numero" style="height: 34px;"
    class="form-control obrigatorios cep" value="<?php echo $numero; ?>"
    onKeyPress="return somenteNumeros(event);" required />
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
        <input autocomplete="off" type="text" name="complemento" id="complemento" style="height: 34px;"
        class="form-control" value="<?php echo $complemento; ?>" />
        <div class="valid-feedback">
            Ok!
        </div>
        <div class="invalid-feedback">
            Preencha o Complemento!
        </div>
    </div>
    <div class="col-md-4">
        <label class="label_titulos">Bairro</label>
        <input autocomplete="off" type="text" name="bairro" id="bairro" style="height: 34px;"
        class="form-control obrigatorios" value="<?php echo $bairro; ?>" required />
        <div class="valid-feedback">
            Ok!
        </div>
        <div class="invalid-feedback">
            Preencha o Bairro!
        </div>
    </div>
    <div class="col-md-4">
        <label class="label_titulos">Cidade</label>
        <input autocomplete="off" type="text" name="cidade" id="cidade" style="height: 34px;"
        class="form-control obrigatorios" value="<?php echo $cidade; ?>" required />
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
        <input autocomplete="off" type="text" name="estado" id="estado" style="height: 34px;"
        class="form-control obrigatorios" value="<?php echo $estado; ?>" required />
        <div class="valid-feedback">
            Ok!
        </div>
        <div class="invalid-feedback">
            Preencha o Estado!
        </div>
    </div>
    <div class="col-md-4">
        <label class="label_titulos">Telefone 1</label>
        <input autocomplete="off" type="tel" name="telefone1" id="telefone1" style="height: 34px;"
        class="form-control obrigatorios phone" value="<?php echo $telefone1; ?>"
        onKeyPress="return somenteNumeros(event);" required />
        <div class="valid-feedback">
            Ok!
        </div>
        <div class="invalid-feedback">
            Preencha o Telefone 1!
        </div>
    </div>
    <div class="col-md-4">
        <label class="label_titulos">Telefone 2</label>
        <input autocomplete="off" type="tel" name="telefone2" id="telefone2" style="height: 34px;"
        class="form-control phone" value="<?php echo $telefone2; ?>"
        onKeyPress="return somenteNumeros(event);" />
    </div>
</div>
<br>
<div class="form-row">
    <div class="col-md-12">
        <label class="label_titulos">E-mail</label>
        <input autocomplete="off" type="email" name="email_user" id="email_user" style="height: 34px;"
        class="form-control obrigatorios" value="<?php echo $email; ?>" required />
        <div class="valid-feedback">
            Ok!
        </div>
        <div class="invalid-feedback">
            Preencha o E-mail!
        </div>
    </div>
</div>
</div>
</form>

<script src="js/valida_cpf_cnpj.js"></script>
<script>
    $('#trocarSenha').click(function() {
        $('#div_nova_senha').css('display', $(this)[0].checked ? 'block' : 'none');
        $('#ckb_trocarSenha').val($(this)[0].checked ? 1 : 0);
    });
</script>



<script>
    $(document).ready(function() {

        $('.valor').priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
    });
</script>