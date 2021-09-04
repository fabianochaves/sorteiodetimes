<?php
/* GRAVAR CADASTRO DE USUÁRIO */
include("../../Connections/connpdo.php");

$nome = addslashes(utf8_decode($_POST['nome']));
$perfil = $_POST['perfil'];
$telefone = $_POST['telefone'];
$goleiro = $_POST['goleiro'];
$nivel = $_POST['nivel'];
$email = addslashes(utf8_decode($_POST['email']));
$login = addslashes(utf8_decode($_POST['login']));
$senha = md5($_POST['senha']);
$status = 1;

$busca = $conn->prepare("SELECT * FROM usuarios WHERE email_usuario='$email' OR login_usuario='$login'");

try 
{
	$busca->execute();
} 
catch (PDOException $e) 
{
	$e->getMessage();
}

if ($busca->rowCount() >= 1)
{
	echo 'erro_Usuário já Cadastrado!';
	return false;
}
else
{
    $insere = $conn->prepare("INSERT INTO usuarios 
    (nome_usuario,login_usuario,senha_usuario,perfil_usuario,
	telefone_usuario,
    email_usuario,status_usuario) 
    VALUES 
    ('$nome','$login','$senha','$perfil',
	'$telefone',
    '$email','$status')");
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
		
		echo 'ok_' . $id_usuario;
		return false;
	}
}

?>