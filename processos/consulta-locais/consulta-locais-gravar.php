<?php
//GRAVAÇÃO EDITAR LOCAL
include("../../Connections/connpdo.php");

$id = $_POST['id'];
$nome = addslashes($_POST['nome']);


$busca_nome = $conn->prepare("SELECT * FROM locais WHERE nome_local = '$nome'  AND id_local != $id");

try 
{
	$busca_nome->execute();
} 
catch (PDOException $e) 
{
	$e->getMessage();
}

if ($busca_nome->rowCount() >= 1)
{
	$msg = "Local já Cadastrado!";
	echo 'erro_' . $msg;
	return false;
}
else
{
	
	$update = $conn->prepare("
		UPDATE locais 
		SET 
		nome_local = '$nome'
		WHERE id_local = '$id'
		");

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
		
			echo 'ok_edicao';
			return false;
		}
		else
		{
			echo 'erro_update';
			return false;
		}
	
}
?>