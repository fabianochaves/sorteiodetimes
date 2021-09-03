<?php
/* CXESCAD003GRA - CADASTRO DE USUÁRIO */
include("../../Connections/connpdo.php");
include("CXESCAD003LOG.php");

$nome = addslashes(utf8_decode($_POST['nome']));
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

$login = addslashes(utf8_decode($_POST['login_user']));
$senha = md5($_POST['senha_user']);

$status = 1;

$busca_cpf = $conn->prepare("SELECT * FROM usuarios WHERE cpf_usuario='$cpf' OR login_usuario='$login'");

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
	echo 'erro_Usuário já Cadastrado!';
	return false;
}
else
{
    $insere = $conn->prepare("INSERT INTO usuarios 
    (nome_usuario,login_usuario,senha_usuario,perfil_usuario,
	tabela_usuario,comissao_usuario,modulos_perm_usuario, regiao_usuario,
    empresa_usuario,cpf_usuario,cep_usuario,rua_usuario,
    nro_usuario,bairro_usuario,comp_usuario,cidade_usuario,
    estado_usuario,telefone1_usuario,telefone2_usuario,
    email_usuario,nascimento_usuario,status_usuario) 
    VALUES 
    ('$nome','$login','$senha','$perfil',
	'$tabelaPadrao','$comissao','$modulosPermitidos', '$regiao',
    '$empresa','$cpf','$cep','$rua',
    '$numero','$bairro','$complemento','$cidade',
    '$estado','$telefone1','$telefone2',
    '$email','$nascimento','$status')");

	try 
	{
		$insere->execute();
	} 
	catch (PDOException $e) 
	{
		$e->getMessage();
	}

	if($insere == true)
	{
		$id_usuario = $conn->lastInsertId();
		
        if ($id_usuario != 0)
		{
			$logCadastro = obterLogCadastro($conn, $id_usuario);
			$logCadastro->salvar();
		}

		echo 'ok_' . $id_usuario;
		return false;
	}
}

?>