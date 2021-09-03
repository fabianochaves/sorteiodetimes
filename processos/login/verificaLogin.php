<?php
session_start();
include("../../Connections/connpdo.php");

if((isset($_POST['usuario'])) AND isset($_POST['senha']) AND ($_POST['usuario'] != "") AND ($_POST['senha'] != ""))
{
	$login = addslashes($_POST['usuario']);
	$senha = addslashes(md5($_POST['senha']));

	$busca_user = $conn->prepare(
		"SELECT * FROM usuarios u 
		INNER JOIN perfis p ON (u.perfil_usuario = p.id_perfil)
		WHERE u.login_usuario = '$login' AND u.senha_usuario = '$senha'"
	);

	try {
		$busca_user->execute();
	} 
	catch (PDOException $e) {
		$e->getMessage();
	}
	
	$row_user = $busca_user->fetch(PDO::FETCH_ASSOC);
	
	if($busca_user->rowCount() >= 1)
	{
		$perfil = $row_user['perfil_usuario'];
		$status = $row_user['status_usuario'];

		if ($status == 0)
		{
			echo "erro_Usuário Inativo!";
			return false;
		}
		else
		{
			$_SESSION['user'] = $row_user['id_usuario'];
			$_SESSION['nome'] = $row_user['nome_usuario'];
			$_SESSION['perfil'] = $row_user['perfil_usuario'];
			$_SESSION['nome_sistema'] = "Sistema para Partidas de Futebol";
			$_SESSION["sessiontime"] = time()+900;
			echo "ok_logado";
		}
	}
	else
	{
		echo "erro_Usuário ou Senha Incorretos!";
	}
}
else
{
	echo "erro_Preencha os campos!";
}