<?php
//CXESCAD001GRA - MPS 24/11/2020 - CADASTRO DE PERFIL
include("../../Connections/connpdo.php");
include("CXESCAD042LOG.php");

$tipo = $_POST['tipo'];
$nome = addslashes(utf8_decode($_POST['nome']));
$rotina = addslashes(utf8_decode($_POST['rotina']));
$icone = $_POST['icone'];
$menu = $_POST['menu'];
$status = 1;

if ($tipo == 0)
{
    $rotina = '';
}

$busca_nome = $conn->prepare("SELECT * FROM menus WHERE nome_menu='$nome' AND menu_menu='$menu'");

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
	echo 'erro_Já existe um registro com este nome no mesmo menu!';
	return false;
}
else
{
	$menu_mesma_rotina = false;

	if ($tipo != 0)
	{
		$busca_rotina = $conn->prepare("SELECT * FROM menus WHERE rotina_menu='$rotina'");

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
		$insere = $conn->prepare("
			INSERT INTO menus 
			(tipo_menu,nome_menu,icone_menu,rotina_menu,menu_menu,status_menu) 
			VALUES 
			('$tipo','$nome','$icone','$rotina','$menu','$status')
		");

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
			$id_menu = $conn->lastInsertId();

			if ($id_menu != 0)
			{
				$logCadastro = obterLogCadastro($conn, $id_menu);
				$logCadastro->salvar();
			}

			echo 'ok_' . $id_menu;
			return false;
		}
	}
}

//////////////////////////////////////////////////////////////////////////////

function permitirMenuAoPerfil($conn, $menuID, $perfilID)
{
	$select_adm = $conn->prepare("SELECT permissoes_perfil FROM perfis WHERE id_perfil = $perfilID");

	try 
	{
		$select_adm->execute();

		if ($row_adm = $select_adm->fetch(PDO::FETCH_ASSOC))
		{
			$permissoes_adm = $row_adm['permissoes_perfil'];
	
			$permissoes_adm = $permissoes_adm != ""
				? "$permissoes_adm^$menuID" : "$permissoes_adm";
	
			$update_adm = $conn->prepare("UPDATE perfis 
			SET permissoes_perfil = '$permissoes_adm' 
			WHERE id_perfil = $perfilID");
	
			try 
			{
				$update_adm->execute();
			} 
			catch (PDOException $e) 
			{
				$e->getMessage();
			}
		}
	} 
	catch (PDOException $e) 
	{
		$e->getMessage();
	}
}
?>