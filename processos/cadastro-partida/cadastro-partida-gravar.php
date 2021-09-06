<?php
/* GRAVAR CADASTRO DE USUÁRIO */
include("../../Connections/connpdo.php");

$data = addslashes(utf8_decode($_POST['data_partida']));
$data = date("Y-m-d", strtotime($data));
$hora = addslashes(utf8_decode($_POST['hora']));
$local = $_POST['local'];

$busca = $conn->prepare("SELECT * FROM partidas WHERE data_partida='$data' AND hora_partida='$hora' AND local_partida = '$local'");

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
	echo 'erro_Partida já Cadastrada!';
	return false;
}
else
{
    $insere = $conn->prepare("INSERT INTO partidas 
    (local_partida,data_partida,hora_partida,status_partida) 
    VALUES 
    ('$local','$data','$hora',1)");
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
		$id_partida = $conn->lastInsertId();
		
		echo 'ok_' . $id_partida;
		return false;
	}
}

?>