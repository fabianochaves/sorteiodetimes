<?php
/* CXESCAD003DESAT - MPS 02/12/2020 - MODAL ALTERAR STATUS CONSULTA DO USUÁRIO */
include("../../Connections/connpdo.php");	
include("../CXESCAD003/CXESCAD003LOG.php");

if(isset($_POST['id']))
{
	$id = $_POST['id'];
	$status = $_POST['status'];

	$status_novo = $status == 1 ? 0 : 1;

	$acao = $conn->prepare("
	UPDATE usuarios 
	SET status_usuario = $status_novo 
	WHERE id_usuario = $id 
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