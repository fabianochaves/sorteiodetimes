<?php
/* MODAL ALTERAR STATUS MÓDULO GERAL */
include("../../Connections/connpdo.php");

if(isset($_POST['id']))
{
	$id = $_POST['id'];
	$status = $_POST['status'];

	$status_novo = $status == 1 ? 0 : 1;

	$acao = $conn->prepare("
	UPDATE locais 
	SET status_local = $status_novo 
	WHERE id_local = $id 
	");
	
	try {
		$acao->execute();
	} 
	catch (PDOException $e) {
		$e->getMessage();
	}

	if ($acao == true)
	{
		echo "ok";
	}
	else
	{
		echo "erro";
	}
}

else
{
	header("location: ../../inicio");
}
?>