<?php
/* GRAVAR CADASTRO DE USUÁRIO */
include("../../Connections/connpdo.php");

$nome = addslashes(utf8_decode($_POST['nome']));

$busca = $conn->prepare("SELECT * FROM locais WHERE nome_local ='$nome'");

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
	echo 'erro_Local já Cadastrado!';
	return false;
}
else
{
    $insere = $conn->prepare("INSERT INTO locais 
    (nome_local,status_local) 
    VALUES 
    ('$nome',1)");
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
		$id_local = $conn->lastInsertId();
		
		echo 'ok_' . $id_local;
		return false;
	}
}

?>