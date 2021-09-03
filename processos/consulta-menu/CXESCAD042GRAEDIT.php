<?php
//CXESCAD042GRAEDIT - MPS 18/12/2020 - CADASTRO DE MÓDULO GERAL
include("../../Connections/connpdo.php");
include("../CXESCAD042/CXESCAD042LOG.php");

$id = $_POST['id'];
$tipo = $_POST['tipo'];
$nome = addslashes(utf8_decode($_POST['nome']));
$rotina = addslashes(utf8_decode($_POST['rotina']));
$icone = $_POST['icone'];
$menu = $_POST['menu'];

if ($tipo == 0)
{
    $rotina = '';
}

$busca_nome = $conn->prepare("SELECT * FROM menus WHERE nome_menu = '$nome' AND menu_menu = '$menu' AND id_menu != $id");

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
	$msg = "Módulo Geral já Cadastrado!";
	echo 'erro_' . $msg;
	return false;
}
else
{
	$menu_mesma_rotina = false;

	if ($tipo != 0)
	{
		$busca_rotina = $conn->prepare("SELECT * FROM menus WHERE rotina_menu = '$rotina' AND id_menu != $id");

		try 
		{
			$busca_rotina->execute();
		} 
		catch (PDOException $e) 
		{
			$e->getMessage();
		}
	
		$menu_mesma_rotina = $busca_rotina->rowCount() >= 1;
	}
	
	if ($menu_mesma_rotina)
	{
		echo 'erro_Já existe um registro com esta rotina!';
		return false;
	}
	else
	{
		$logAlteracao = obterLogAlteracao($conn, $id);

		$update = $conn->prepare("
		UPDATE menus 
		SET 
		nome_menu = '$nome',
		icone_menu = '$icone',
		rotina_menu = '$rotina',
		menu_menu = '$menu'
		WHERE id_menu = '$id'
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
			$logAlteracao->salvar();

			echo 'ok_edicao';
			return false;
		}
		else
		{
			echo 'erro_update';
			return false;
		}
	}
}
?>