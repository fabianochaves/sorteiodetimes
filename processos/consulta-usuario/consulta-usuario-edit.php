<?php
include("../../Connections/connpdo.php");
date_default_timezone_set('America/Sao_Paulo');

$id = $_POST['id'];

$busca = $conn->prepare("SELECT * FROM usuarios u INNER JOIN perfis p ON(p.id_perfil = u.perfil_usuario)
WHERE id_usuario = $id");

try {
    $busca->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

$row = $busca->fetch(PDO::FETCH_ASSOC);

$nome = $row['nome_usuario'];
$login = $row['login_usuario'];
$email = $row['email_usuario'];
$telefone = $row['telefone_usuario'];
$perfil = $row['perfil_usuario'];
$nivel = $row['nivel_usuario'];
$goleiro = $row['goleiro_usuario'];
$status = $row['status_usuario'];

?>

<form class="needs-validation offset-md-12 col-md-12 " name="formulario" id="formulario" method="POST" novalidate>
    <br>
    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id; ?>" />
     <div class="form-row">
        <div class="col-md-4">
            <label class="label_titulos">Nome</label>
            <input autocomplete="off" type="text" name="nome" id="nome" style="height: 34px;" class="form-control obrigatorios somenteLetras" value="<?php echo $nome; ?>" required />
            <div class="valid-feedback">
                Ok!
            </div>
            <div class="invalid-feedback">
                Preencha o Nome!
            </div>
        </div>
        <div class="col-md-5">
            <label class="label_titulos">E-mail</label>
            <input autocomplete="off" type="email" name="email" id="email" style="height: 34px;" class="form-control obrigatorios" value="<?php echo $email; ?>" required />
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

                    if($row_perfil['id_perfil'] == $perfil)
                    {
                        $selected = "selected";
                    }
                    else
                    {
                        $selected = "";
                    }
                    echo '<option '.$selected.' value="' . $row_perfil['id_perfil'] . '">' . $row_perfil['nome_perfil'] . '</option>';
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
            <select data-placeholder="Escolha..." name="nivel" id="nivel" class="form-control obrigatorios chosen-select" tabindex="2" required>
                <option selected value="">Escolha...</option>
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    if($nivel == $i)
                    {
                        $selected = "selected";
                    }
                    else
                    {
                        $selected = "";
                    }
                ?>
                    <option <?php echo $selected; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
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
            <select data-placeholder="Escolha..." name="goleiro" id="goleiro" class="form-control obrigatorios chosen-select" tabindex="2" required>
                <option selected value="">Escolha...</option>
                <option <?php if($goleiro == 1){echo "selected";} ?> value="1">Sim</option>
                <option <?php if($goleiro == 0){echo "selected";} ?> value="0">Não</option>
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
            <input value="<?php echo $telefone; ?>" autocomplete="off" type="tel" name="telefone" id="telefone" style="height: 34px;" class="form-control obrigatorios phone" value="" onKeyPress="return somenteNumeros(event);" required />
            <div class="valid-feedback">
                Ok!
            </div>
            <div class="invalid-feedback">
                Preencha o Telefone!
            </div>
        </div>
        <div class="col-md-3">
            <label class="label_titulos">Login</label>
            <input autocomplete="off" type="text" name="login" id="login" style="height: 34px;" class="form-control obrigatorios somenteTextoSemCaracteresEspeciais"value="<?php echo $login; ?>" required />
            <div class="valid-feedback">
                Ok!
            </div>
            <div class="invalid-feedback">
                Preencha o Login!
            </div>
        </div>
        <div class="col-md-3">
            <label class="label_titulos">Senha</label>
            <input autocomplete="new-password" type="password" name="senha" id="senha" style="height: 34px;" class="form-control" value="" />
            <div class="valid-feedback">
                Ok!
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
</form>

<script src="js/consultas/consulta-usuario/acoes-editar.js"></script>