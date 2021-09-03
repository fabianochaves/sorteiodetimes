<?php
if (file_exists('Connections/connpdo.php')) include_once('Connections/connpdo.php');

if (!isset($considerar_permissoes))
    $considerar_permissoes = false;

$busca = $conn->prepare("SELECT * FROM menus WHERE status_menu = 1 ORDER BY menu_menu ASC, nome_menu ASC");

if ($considerar_permissoes == true)
{
    $id_perfil = $_SESSION['perfil'];
    $permissoes = '0';
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
        $permissoes = str_replace('^', ',', $row_perfil['permissoes_perfil']);
    }

    $busca = $conn->prepare("SELECT * FROM menus WHERE status_menu=1 AND 
    id_menu IN ($permissoes) ORDER BY menu_menu ASC, nome_menu ASC");
}

try 
{
	$busca->execute();
} 
catch (PDOException $e) 
{
	$e->getMessage();
}

$root = array();
$filhos = array();

while($row = $busca->fetch(PDO::FETCH_ASSOC))
{
    $menu_info = array(
        'id' => $row['id_menu'],
        'tipo' => $row['tipo_menu'],
        'nome' => $row['nome_menu'],
        'icone' => $row['icone_menu'],
        'rotina' => $row['rotina_menu'],
        );

    if($row['menu_menu'] != 0)
    {
        $filhos[$row['menu_menu']][$row['id_menu']] = $menu_info;
    }
    else
    {           
        $root[$row['id_menu']] = $menu_info;
    }
}

foreach($filhos as $key => &$filho)
{
    $root = AdicionarNoMenu($root, $key, $filho);
}

function AdicionarNoMenu($raiz, $pai, $filho)
{
    if (array_key_exists($pai, $raiz))
    {
        if ($raiz[$pai]['tipo'] == 0)
        {
            $raiz[$pai]['menus'] = $filho;
        }        
    }
    else
    {
        foreach($raiz as $key => &$menu)
        {
            if (array_key_exists('menus', $menu))
            {
                $raiz[$key]['menus'] = AdicionarNoMenu($menu['menus'], $pai, $filho);
            }
        }
    }

    return $raiz;
}
?>