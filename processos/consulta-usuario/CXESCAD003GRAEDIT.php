<?php
/* CXESCAD003GRAEDIT - EDIÇÃO DE USUÁRIO */
include("../../Connections/connpdo.php");
include("../CXESCAD003/CXESCAD003LOG.php");

$id_usuario = $_POST['id_usuario'];
$nome = addslashes(utf8_decode($_POST['nome']));
$login = addslashes(utf8_decode($_POST['login_user']));
$cpf = $_POST['cpf'];
$empresa = $_POST['empresa'];
$perfil = $_POST['perfil'];
$tabelaPadrao = $_POST['tabela_padrao'];
$comissao = str_replace(",",".", $_POST['comissao']);
$modulosPermitidos = $_POST['modulos_permitidos'];
$regiao = $_POST['regiao'];

$exp_nasc = explode('/', $_POST['nascimento']);
$nascimento = $exp_nasc[2] . '-' . $exp_nasc[1] . '-' . $exp_nasc[0];

$cep = $_POST['cep'];
$rua = addslashes(utf8_decode($_POST['rua']));
$numero = addslashes(utf8_decode($_POST['numero']));
$complemento = addslashes(utf8_decode($_POST['complemento']));
$bairro = addslashes(utf8_decode($_POST['bairro']));
$cidade = addslashes(utf8_decode($_POST['cidade']));
$estado = addslashes(utf8_decode($_POST['estado']));

$telefone1 = $_POST['telefone1'];
$telefone2 = $_POST['telefone2'];
$email = addslashes(utf8_decode($_POST['email_user']));

$queryTrocarSenha = '';
if ($_POST['ckb_trocarSenha'] == 1)
{
    $novaSenha = addslashes(md5($_POST['nova_senha']));
    $queryTrocarSenha = "senha_usuario = '$novaSenha',";
}

$busca_cpf = $conn->prepare("SELECT * FROM usuarios WHERE cpf_usuario='$cpf' AND id_usuario != $id_usuario");

try 
{
	$busca_cpf->execute();
} 
catch (PDOException $e) 
{
	$e->getMessage();
}

if ($busca_cpf->rowCount() >= 1)
{
	echo 'erro_Já existe um usuário com este CPF!';
	return false;
}
else
{
    $busca_login = $conn->prepare("SELECT * FROM usuarios WHERE login_usuario='$login' AND id_usuario != $id_usuario");

    try 
    {
        $busca_login->execute();
    } 
    catch (PDOException $e) 
    {
        $e->getMessage();
    }
    
    if ($busca_login->rowCount() >= 1)
    {
        echo 'erro_Já existe um usuário com este Login!';
        return false;
    }
    else
    {
        $logAlteracao = obterLogAlteracao($conn, $id_usuario);
    
        $update = $conn->prepare("UPDATE usuarios SET 
        nome_usuario = '$nome',
        login_usuario = '$login',
        $queryTrocarSenha
        perfil_usuario = '$perfil',
        empresa_usuario = '$empresa',
        tabela_usuario = '$tabelaPadrao',
        comissao_usuario = '$comissao',
        modulos_perm_usuario = '$modulosPermitidos',
        regiao_usuario = '$regiao',
        cpf_usuario = '$cpf',
        cep_usuario = '$cep',
        rua_usuario = '$rua',
        nro_usuario = '$numero',
        bairro_usuario = '$bairro',
        comp_usuario = '$complemento',
        cidade_usuario = '$cidade',
        estado_usuario = '$estado',
        telefone1_usuario = '$telefone1',
        telefone2_usuario = '$telefone2',
        email_usuario = '$email',
        nascimento_usuario = '$nascimento' 
        WHERE id_usuario = $id_usuario");
    
        try 
        {
            $update->execute();
        } 
        catch (PDOException $e) 
        {
            $e->getMessage();
        }
    
        if($update == true)
        {
            $logAlteracao->salvar();
            
            echo 'ok_Alterado com sucesso!';
            return false;
        }
    }
}

?>