<?php
$considerar_permissoes = false;
if (file_exists('processos/menu/obterMenuArr.php')) include_once('processos/menu/obterMenuArr.php');

if (!isset($perm)) $perm = array();

$html = '<div style="border: 1px lightgray solid; border-radius: 1px; margin-top: 5px">
<div style="max-height: 200px; overflow-y: auto; padding: 5px;">
<ul style="list-style-type:none;">
'.GerarMenuTreeView($root, $perm).'</ul></div></div>';

echo $html;

// FUNÇÃO RECUSRIVA QUE GERA O MENU DINÂMICAMENTE ACESSANDO OS MENUS FILHOS DE CADA ITEM
function GerarMenuTreeView($menus, $perm)
{
    $html = '';

    foreach ($menus as $key => $menu)
    {
        $menu_idd = 'menu_'.$menu['id'];
        $value = in_array($menu['id'], $perm) ? 1 : 0;
        $checked = $value == 1 ? 'checked' : '';
        //$collapse = $value == 1 ? '' : 'collapse';
        $collapse = '';
        $arrow = '▼';

        $menu_input = '
        <label><input '.$checked.' id="'.$menu_idd.'" name="'.$menu_idd.'" 
        type="checkbox" value="'.$value.'" onChange="ChangeTreeViewValue(\''.$menu_idd.'\');"/> 
        '.$menu['nome'].'</label>';

        $html = "$html<li>".$menu_input;
    
        if (array_key_exists('menus', $menu))
        {
            $html = $html.'<a style="cursor: pointer" onClick="CollapseMenuTreeView(\''.$menu_idd.'\')"> '.$arrow.'</i></a>';
            $html_child = GerarMenuTreeView($menu['menus'], $perm);

            if ($html_child != '')
                $html = "$html<ul class='".$collapse."' style='list-style-type:none;'>$html_child</ul>";
        }
        
        $html = "$html</li>";
    }
    
    return $html;
}
?>

<script>
function CollapseMenuTreeView(id) {
    const ckb = document.getElementById(id);
    const parent_li = ckb.parentElement.parentElement;
    const ul = parent_li.getElementsByTagName('ul')[0];

    if (parent_li.tagName.toLowerCase() == 'li') {
        if (ul.className.includes('collapse')) {
            parent_li.getElementsByTagName('a')[0].innerHTML = '▼';
            ul.className = '';
        } else {
            parent_li.getElementsByTagName('a')[0].innerHTML = '▲';
            ul.className = 'collapse';
        }
    }
}

function ChangeTreeViewValue(id) {
    const ckb = document.getElementById(id);
    const uls = ckb.parentElement.parentElement.getElementsByTagName('ul');
    const parent_ul = ckb.parentElement.parentElement.parentElement;
    const parent_li = parent_ul.parentElement;
    let parent_input = null;

    if (parent_li.tagName.toLowerCase() == 'li')
        parent_input = parent_li.getElementsByTagName('input')[0];

    ckb.value = ckb.checked == true ? 1 : 0;

    if (parent_input != null && ckb.checked) {
        parent_input.checked = true;
        parent_input.value = 1;
    }

    for (let i = 0; i < uls.length; i++) {
        let lis = uls[i].getElementsByTagName('li');

        for (let j = 0; j < lis.length; j++) {
            let input_child = lis[j].getElementsByTagName('input')[0];
            input_child.checked = ckb.checked;
            input_child.value = ckb.value;
        }
    }
}
</script>