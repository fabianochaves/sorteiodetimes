<?php
/* CONFIRMAR/CANCELAR PRESENÇA DE JOGADOR */
include("../../Connections/connpdo.php");

if (isset($_POST['id'])) {
	$id = $_POST['id'];

	//INSERE
	$acao = $conn->prepare("
		UPDATE partidas SET status_partida = 2 WHERE id_partida = '$id'
	");
	try {
		$update = $acao->execute();
	} catch (PDOException $e) {
		$update = $e->getMessage();
	}

	if($update == 1)
	{
		echo "ok";
	}
	else{
		echo $update;
	}
	
} else {
	header("location: ../../inicio");
}
