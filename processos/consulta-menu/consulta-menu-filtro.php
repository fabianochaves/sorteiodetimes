<?php
/* CONSULTA DE MÓDULO GERAL */

include('../../Connections/connpdo.php');
date_default_timezone_set('America/Sao_Paulo');
session_start();

$busca = $conn->prepare("
SELECT * FROM menus 
");

try {
	$busca->execute();
} 
catch (PDOException $e) {
	$e->getMessage();
}

?>

<div class="app-main__inner">
    <table id="tab_grid" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <?php echo "<th><center>#</center></th>";?>
                <!--- <th><center>Sequência</center></th> !--->
                <th>
                    <center>Código</center>
                </th>
                <th>
                    <center>Tipo</center>
                </th>
                <th>
                    <center>Rotina</center>
                </th>
                <th>
                    <center>Nome</center>
                </th>
                <th>
                    <center>Ícone</center>
                </th>
                <th>
                    <center>Menu</center>
                </th>
                <th>
                    <center>Status</center>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $menus = array();

            while($menu = $busca->fetch(PDO::FETCH_ASSOC))
            {
                $menus[$menu['id_menu']] = $menu;
            }
			
			foreach ($menus as $id => &$row)
			{
                $id = $row['id_menu'];
                $tipo = $row['tipo_menu'];

                if ($tipo == 1)
                {
                    $tipo = 'Módulo';
                    $rotina = $row['rotina_menu'];
                }
                else
                {
                    $tipo = 'Menu';
                    $rotina = '-';
                }                
                
                $nome = $row['nome_menu'];
                $icone = $row['icone_menu'];
             
                $status = $row['status_menu'];
                
                $nomes_menu = '';
                $ultimo_menu = $row['menu_menu'];
                if ($ultimo_menu > 0)
                {
                    while ($ultimo_menu > 0)
                    {
                        if (!array_key_exists($ultimo_menu, $menus))
                        {
                            break;
                        }
    
                        $nomes_menu = $menus[$ultimo_menu]['nome_menu']."/".$nomes_menu;
                        $ultimo_menu = $menus[$ultimo_menu]['menu_menu'];
                    }
                }
                $nomes_menu = $ultimo_menu == 0 ? 'Principal/' . $nomes_menu : 'Indefinido';
                
                if ($nomes_menu != 'Indefinido' && $nomes_menu != '')
                {
                    $nomes_menu = substr($nomes_menu, 0, strlen($nomes_menu) - 1);
                }
            
                $mensagem_para_modal_desativar = str_replace('_', ' ', $nome);

                if ($status == 1)
                {
                    $nome_status = "Ativo";
                    $cor_status = "green"; 
                    
                    $cor_button = "danger";
                    $icon_button = "fa fa-close";
                }
                else
                {
                    $nome_status = "Inativo";
                    $cor_status = "red";

                    $cor_button = "success";
                    $icon_button = "fa fa-check";
                }

				?>
            <tr>
                <td>
                    <center>
                        <button id="<?php echo $id."_".$mensagem_para_modal_desativar."_".$status; ?>"
                            class="btn btn-<?php echo $cor_button; ?> btn-sm btnDesativar" type="button">
                            <i class="<?php echo $icon_button; ?>" aria-hidden="true"></i></button>

                        <button id="<?php echo $id ?>" class="btn btn-warning btn-sm btnEditar" type="button"
                            style="margin-top: 5px">
                            <i class="fa fa-edit" aria-hidden="true"></i></button>
                    </center>
                </td>
                <td>
                    <center><?php echo $id; ?></center>
                </td>
                <td>
                    <center><?php echo $tipo; ?></center>
                </td>
                <td>
                    <center><?php echo $rotina; ?></center>
                </td>
                <td>
                    <center><?php echo $nome; ?></center>
                </td>
                <td>
                    <center><?php echo '<i class="' . $icone . '"></i>' . "<br>$icone"; ?></center>
                </td>
                <td nowrap>
                    <p style="text-align: left; font-size: 95%"><?php echo $nomes_menu; ?></p>
                </td>
                <td>
                    <b>
                        <font color="<?php echo $cor_status; ?>">
                            <center>
                                <?php echo $nome_status; ?>
                            </center>
                        </font>
                    </b>
                </td>
                </td>
            </tr>
            <?php

			}
			?>
        </tbody>

    </table>
</div>

<script src="js/consultas/consulta-menu/acoes-menu.js"></script>