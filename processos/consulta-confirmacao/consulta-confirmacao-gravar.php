<?php
/* CONFIRMAR/CANCELAR PRESENÇA DE JOGADOR */
include("../../Connections/connpdo.php");	

if(isset($_POST['id']))
{
	$id = $_POST['id'];
	$status = $_POST['status'];
	$partida = $_POST['partida'];

	if($status == 0)
	{
		//CONFERE SE JÁ NÃO ESTÁ CONFIRMADO

		$busca = $conn->prepare("
		SELECT * FROM confirmacoes 
		WHERE partida_confirmacao = '$partida' AND usuario_confirmacao = '$id'
		");
		try {
			$busca->execute();
		} 
		catch (PDOException $e) {
			$e->getMessage();
		}

		if($busca->rowCount() == 0)
		{
			//INSERE
			$acao = $conn->prepare("
			INSERT INTO confirmacoes(partida_confirmacao, usuario_confirmacao)
			VALUES('$partida','$id')
			");
			try {
				$acao->execute();
			} 
			catch (PDOException $e) {
				$e->getMessage();
			}
			
		}

		echo "ok";

	}
	else
	{
		//DELETE
		$acao = $conn->prepare("
		DELETE FROM confirmacoes WHERE partida_confirmacao = '$partida' AND usuario_confirmacao = '$id'
		");
		try {
			$acao->execute();
		} 
		catch (PDOException $e) {
			$e->getMessage();
		}
		
		echo "ok";
	
	}
}
else
{
	header("location: ../../inicio");
}
