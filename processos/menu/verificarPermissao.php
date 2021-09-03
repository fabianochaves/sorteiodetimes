<?php
function obterExcessoes()
{
    return 
        array(
            'inicio','login', 'logout', 'menu', 'phpinfo', 'alterarsenha'
        );
}

function VerificarPermissao($rotina)
{
    include('Connections/connpdo.php');
    
    $excessoes_permissao = obterExcessoes();

    $possui_permissao = in_array($rotina, $excessoes_permissao);
    
    if (isset($_SESSION['perfil']) && $possui_permissao === false)
    {
        $id_perfil = $_SESSION['perfil'];
        $permissoes = array();
    
        $busca_perfil = $conn->prepare("SELECT permissoes_perfil FROM perfis WHERE id_perfil = $id_perfil");
    
        try 
        {
            $busca_perfil->execute();
        } 
        catch (PDOException $e) 
        {
            $e->getMessage();
        }
    
        if ($row_perfil = $busca_perfil->fetch(PDO::FETCH_ASSOC))
        {
            $permissoes = explode('^', $row_perfil['permissoes_perfil']);
        }
    
        $busca_modulo = $conn->prepare("SELECT id_menu FROM menus WHERE rotina_menu = ?");
        $busca_modulo->bindParam(1, $rotina);
    
        try 
        {
            $busca_modulo->execute();
        } 
        catch (PDOException $e) 
        {
            $e->getMessage();
        }
    
        if ($row_modulo = $busca_modulo->fetch(PDO::FETCH_ASSOC))
        {
            $possui_permissao = in_array($row_modulo['id_menu'], $permissoes);
        }
    }

    return $possui_permissao;
}