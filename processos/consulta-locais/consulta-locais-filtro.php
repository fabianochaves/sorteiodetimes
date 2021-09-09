<?php
/* CONSULTA DE LOCAIS */

include('../../Connections/connpdo.php');
date_default_timezone_set('America/Sao_Paulo');
session_start();

$busca = $conn->prepare("
SELECT * FROM locais 
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
                    <center>Nome</center>
                </th>
                <th>
                    <center>Status</center>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            while($row = $busca->fetch(PDO::FETCH_ASSOC))
            {
             
                $id = $row['id_local'];
                $nome = $row['nome_local'];
                $status = $row['status_local'];
               
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

                $mensagem_para_modal_desativar = str_replace('_', ' ', $nome);

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
                    <center><?php echo $nome; ?></center>
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

<script src="js/consultas/consulta-locais/acoes-local.js"></script>