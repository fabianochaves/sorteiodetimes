<?php
/* EDIÇÃO DE USUÁRIO */
include("../../Connections/connpdo.php");

$id_usuario = $_POST['id_usuario'];
$nome = addslashes($_POST['nome']);
$login = addslashes($_POST['login']);
$perfil = $_POST['perfil'];
$telefone = $_POST['telefone'];
$nivel = $_POST['nivel'];
$goleiro = $_POST['goleiro'];
$email = addslashes($_POST['email']);
$senha = addslashes($_POST['senha']);

if($senha != "")
{
    $senha = md5($senha);
    $set_senha = "senha_usuario = '".$senha . "',";
}
else{
    $set_senha = "";
}

$busca = $conn->prepare("SELECT * FROM usuarios WHERE login_usuario='$login' AND id_usuario != $id_usuario");

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
	echo 'erro_Já existe um usuário com este Login!';
	return false;
}
else
{
    $busca_email = $conn->prepare("SELECT * FROM usuarios WHERE email_usuario='$email' AND id_usuario != $id_usuario");

    try 
    {
        $busca_email->execute();
    } 
    catch (PDOException $e) 
    {
        $e->getMessage();
    }
    
    if ($busca_email->rowCount() >= 1)
    {
        echo 'erro_Já existe um usuário com este E-mail!';
        return false;
    }
    else
    {
        $update = $conn->prepare("UPDATE usuarios SET 
        nome_usuario = '$nome',
        login_usuario = '$login',
        perfil_usuario = '$perfil',
        nivel_usuario = '$nivel',
        goleiro_usuario = '$goleiro',
        telefone_usuario = '$telefone',
        $set_senha
        email_usuario = '$email'
        WHERE id_usuario = $id_usuario");
    
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
            echo 'ok_Alterado com sucesso!';
            return false;
        }
    }
}

?>