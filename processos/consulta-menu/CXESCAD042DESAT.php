<?php
/* CXESCAD042DESAT - 18/12/2020 - MODAL ALTERAR STATUS MÓDULO GERAL */
include("../../Connections/connpdo.php");
include("../CXESCAD042/CXESCAD042LOG.php");

if(isset($_POST['id']))
{
	$id = $_POST['id'];
	$status = $_POST['status'];

	$status_novo = $status == 1 ? 0 : 1;

	$acao = $conn->prepare("
	UPDATE menus 
	SET status_menu = $status_novo 
	WHERE id_menu = $id 
	");
	
	try {
		$acao->execute();
	} 
	catch (PDOException $e) {
		$e->getMessage();
	}

	if ($acao == true)
	{
		$logStatus = obterLogStatus($conn, $id, $status, $status_novo);
		$logStatus->salvar();
		
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