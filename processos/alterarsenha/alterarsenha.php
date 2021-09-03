<?php
//MPS 13/01/2021 - ALTERAR SENHA

session_start();
include("../../Connections/connpdo.php");

if (isset($_SESSION['user']) == false)
{
    echo 'erro_Sua sessão expirou, atualize a página!';
    return false;
}
else if (isset($_POST['senha_atual']) || isset($_POST['senha_nova']) || isset($_POST['senha_nova_confirma']))
{
    $usuarioID = $_SESSION['user'];
    $senhaAtual = $_POST['senha_atual'];
    $senhaNova = $_POST['senha_nova'];
    $senhaNovaConfirma = $_POST['senha_nova_confirma'];

    if ($senhaAtual == '' || $senhaNova == '' || $senhaNovaConfirma == '')
    {
        echo 'erro_Preencha os campos!';
    }
    else if (strlen($senhaNova) < 6)
    {
        echo 'erro_A senha nova deve conter no mínimo 6 caracteres';
    }
    else if (validarSenhaAtualDoUsuario($conn, $usuarioID, $senhaAtual) == false)
    {
        echo 'erro_Senha atual incorreta!';
    }
    else if ($senhaNova !== $senhaNovaConfirma)
    {
        echo 'erro_A senha nova não confirma!';
    }
    else if (alterarSenha($conn, $usuarioID, $senhaNova))
    {
        echo 'ok_Senha alterada com sucesso!';
        return true;
    }
    else
    {
        echo 'erro_Não foi possível alterar a senha!';
    }

    return false;
}
else
{
    echo 'erro_Preencha os campos!';
    return false;
}
?>

<?php
// ################################################################### //
// ############################# FUNÇÕES ############################# //
// ################################################################### //

function validarSenhaAtualDoUsuario($conn, $usuarioID, $senha)
{
    $senhaMD5 = md5($senha);

    $buscar_usuario = $conn->prepare("
        SELECT * FROM usuarios 
        WHERE id_usuario = '$usuarioID' 
        AND senha_usuario = '$senhaMD5'");

    try 
    {
        $buscar_usuario->execute();
    } 
    catch (PDOException $e) 
    {
        $e->getMessage();
    }
    
    if ($buscar_usuario->rowCount() >= 1)
    {
        return true;
    }

    return false;
}

function alterarSenha($conn, $usuarioID, $senha)
{
    $senhaMD5 = md5($senha);

    $usuario_alterar_senha = $conn->prepare("
        UPDATE usuarios 
        SET 
        senha_usuario = '$senhaMD5' 
        WHERE id_usuario = '$usuarioID'
        ");

    try 
    {
        if ($usuario_alterar_senha->execute())
        {
            return true;
        }        
    } 
    catch (PDOException $e) 
    {
        $e->getMessage();
    }

    return false;
}
?>