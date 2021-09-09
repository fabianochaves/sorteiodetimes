<?php
include_once('processos/menu/obterMenuArr.php');

if (isset($modulo) == false)
    $modulo = '';

$inicioAtivo = $modulo == 'inicio' ? 'id="moduloSelecionado" class="mm-active"' : '';

$html = 
'<ul class="vertical-nav-menu" style="padding-top: 5px">
<div class="form-row"><div class="col-md-12">
<input style="max-width: 215px" class="form-control" id="pesquisar" type="text" placeholder="Pesquisar...">
</div></div>
<li class="app-sidebar__heading">Dashboard</li>
<li>
    <a href="inicio" '. $inicioAtivo .'>
        <i class="metismenu-icon pe-7s-home"></i>
        Início
    </a>
</li>
'.GerarHtmlMenu($root, $modulo).'</ul>';

echo $html;

// FUNÇÃO RECUSRIVA QUE GERA O MENU DINÂMICAMENTE ACESSANDO OS MENUS FILHOS DE CADA ITEM
function GerarHtmlMenu($menus, $modulo)
{
    $html = '';

    foreach ($menus as $key => $menu)
    {
        $mmactive = '';
        $mmshow = '';
        $moduloSelecionado = $key;

        if ($menu['tipo'] == 1)
        {
            $href = URL::getBase().$menu['rotina'];
            $icon1 = 'metismenu-icon';
            $icon2 = $menu['icone'];

            if ($menu['rotina'] == $modulo)
            {
                $moduloSelecionado = 'moduloSelecionado';
                $mmactive = 'mm-active';
            }
        }
        else
        {
            $href = '#';
            $icon1 = $menu['icone'];
            $icon2 = 'metismenu-state-icon pe-7s-angle-down caret-left';

            if (array_key_exists('menus', $menu))
            {
                if (verificarSeMenuContemModulo($modulo, $menu['menus']))
                {
                    $mmactive = 'mm-active';
                    $mmshow = 'mm-collapse mm-show';
                }
            }
        }

        $menu_a = '
        <a href="'.$href.'">
            <i class="'.$icon1.'"></i>
            <div style="display: none">'.$menu['rotina'].'</div>
            '.$menu['nome'].'
            <i class="'.$icon2.'"></i>
        </a>
        ';

        $html = "$html<li id='$moduloSelecionado' class='$mmactive'>".$menu_a;
    
        if (array_key_exists('menus', $menu))
        {
            $html_child = GerarHtmlMenu($menu['menus'], $modulo);

            if ($html_child != '')
                $html = "$html<ul class='$mmshow'>$html_child</ul>";
        }
        
        $html = "$html</li>";
    }
    
    return $html;
}

function verificarSeMenuContemModulo($modulo, $menu)
{
    foreach ($menu as $key => &$menu) {
        if (in_array($modulo, $menu))
            return true;
    }

    return false;
}
?>