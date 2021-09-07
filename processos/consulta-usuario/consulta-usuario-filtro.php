<?php
/* FILTRO CONSULTA DE USUÁRIO */
date_default_timezone_set('America/Sao_Paulo');
session_start();

include('../../Connections/connpdo.php');
include('../../classes/Url.php');

$busca = $conn->prepare("SELECT * FROM usuarios u INNER JOIN perfis p ON (u.perfil_usuario = p.id_perfil)");
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
                <th>
                    <center>#</center>
                </th>
                <th>
                    <center>Código</center>
                </th>
                <th>
                    <center>Nome</center>
                </th>
                <th>
                    <center>Perfil</center>
                </th>
                <th>
                    <center>Nível</center>
                </th>
                <th>
                    <center>Goleiro</center>
                </th>
                <th>
                    <center>Login</center>
                </th>
                <th>
                    <center>E-mail</center>
                </th>
                <th>
                    <center>Telefone</center>
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
				$id = $row['id_usuario'];
                $nome = $row['nome_usuario'];
                $login = $row['login_usuario'];
                $nivel = $row['nivel_usuario'];
                $goleiro = $row['goleiro_usuario'];

                if($goleiro == 1)
                {
                    $is_goleiro = "Sim";
                }
                else
                {
                    $is_goleiro = "Não";
                }

                $perfil = $row['nome_perfil'];

                $email = $row['email_usuario'];
                $telefone = $row['telefone_usuario'];
                
                $status = $row['status_usuario'];	
            
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
                <td nowrap>
                    <center>
                       
                        <button id="<?php echo $id."_".$nome."_".$status; ?>" class="btn btn-<?php echo $cor_button; ?> btn-sm btnDesativar" type="button">
                            <i class="<?php echo $icon_button; ?>" aria-hidden="true"></i>
                        </button>
                        <button id="<?php echo $id ?>" class="btn btn-warning btn-sm btnEditar" type="button"
                            style="margin-top: 5px">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </button>
                       
                    </center>
                </td>
                <td>
                    <center><?php echo $id; ?></center>
                </td>
                <td>
                    <center><?php echo $nome; ?></center>
                </td>
                <td>
                    <center><?php echo $perfil; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $nivel; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $is_goleiro; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $login; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $email; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $telefone; ?></center>
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

<script src="js/consultas/consulta-usuario/acoes-usuario.js"></script>