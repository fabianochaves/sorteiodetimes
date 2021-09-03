<?php
/* CXESCAD003FILTRO - MPS 02/12 - Filtro Consulta de Usuário */
date_default_timezone_set('America/Sao_Paulo');
session_start();

include('../../Connections/connpdo.php');
include('../../classes/Url.php');
include('../../classes/permissao/VerificaPermissaoDeFuncionalidade.php');

$permissaoFuncionalidade = new VerificaPermissaoDeFuncionalidade($conn, 'CXESCAD003CON');
$podeDesativar = $permissaoFuncionalidade->verificar(FC_DESATIVAR_REGISTRO);
$podeEditar = $permissaoFuncionalidade->verificar(FC_EDITAR_REGISTRO);
$exibirBotoes = $podeDesativar || $podeEditar;

$filtro_empresa = $_POST['empresaID'];
$filtro_perfil = $_POST['perfilID'];

$queryPerfil = " AND usu.perfil_usuario != 1000";
if ($filtro_perfil != 0)
{
    $queryPerfil = " AND usu.perfil_usuario = $filtro_perfil";
}

if ($filtro_empresa != 0)
{
    $busca = $conn->prepare("SELECT * FROM usuarios usu
    INNER JOIN empresas emp ON emp.id_empresa = usu.empresa_usuario 
    INNER JOIN perfis prf ON prf.id_perfil = usu.perfil_usuario 
    WHERE emp.status_empresa = 1 AND usu.empresa_usuario = ? $queryPerfil
    ");
    $busca->bindParam(1, $filtro_empresa);
}
else
{
    $busca = $conn->prepare("SELECT * FROM usuarios usu
    INNER JOIN empresas emp ON emp.id_empresa = usu.empresa_usuario 
    INNER JOIN perfis prf ON prf.id_perfil = usu.perfil_usuario 
    WHERE emp.status_empresa = 1 $queryPerfil
    ");
}

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
                <th <?php if (!$exibirBotoes) echo 'style="display: none;"'; ?>>
                    <center>#</center>
                </th>
                <th>
                    <center>Código</center>
                </th>
                <th>
                    <center>Nome</center>
                </th>
                <th>
                    <center>CPF</center>
                </th>
                <th>
                    <center>Nascimento</center>
                </th>
                <th>
                    <center>Empresa Padrão</center>
                </th>
                <th>
                    <center>Perfil</center>
                </th>
                <th>
                    <center>Tabela Padrão</center>
                </th>
                <th>
                    <center>Comissão</center>
                </th>
                <th>
                    <center>Módulos Permitidos</center>
                </th>
                <th>
                    <center>Rua</center>
                </th>
                <th>
                    <center>Número</center>
                </th>
                <th>
                    <center>Complemento</center>
                </th>
                <th>
                    <center>Bairro</center>
                </th>
                <th>
                    <center>Cidade</center>
                </th>
                <th>
                    <center>Estado</center>
                </th>
                <th>
                    <center>Login</center>
                </th>
                <th>
                    <center>E-mail</center>
                </th>
                <th>
                    <center>Telefone 1</center>
                </th>
                <th>
                    <center>Telefone 2</center>
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
                $nome = utf8_encode($row['nome_usuario']);
                $login = utf8_encode($row['login_usuario']);
                $cpf = $row['cpf_usuario'];

                $empresa = $row['nome_empresa'];
                $perfil = $row['nome_perfil'];
                $tabelaPadrao = $row['tabela_usuario'];
                $comissao = str_replace(".",",", $row['comissao_usuario']);
                $modulosPermitidos = $row['modulos_perm_usuario'];

                //$nascimento = $row['nascimento_usuario'];
                $nasc_exp = explode('-', $row['nascimento_usuario']);
                $nascimento = $nasc_exp[2].'/'.$nasc_exp[1].'/'.$nasc_exp[0];

                $rua = utf8_encode($row['rua_usuario']);
                $numero = $row['nro_usuario'];
                $complemento = utf8_encode($row['comp_usuario']);
                $bairro = utf8_encode($row['bairro_usuario']);
                $cidade = utf8_encode($row['cidade_usuario']);
                $estado = utf8_encode($row['estado_usuario']);

                $email = utf8_encode($row['email_usuario']);
                $telefone1 = $row['telefone1_usuario'];
                $telefone2 = $row['telefone2_usuario'];
                
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
                <td <?php if (!$exibirBotoes) echo 'style="display: none;"'; ?> nowrap>
                    <center>
                        <?php
                        if ($podeDesativar)
                        {
                        ?>
                        <button id="<?php echo $id."_".$nome."_".$status; ?>"
                            class="btn btn-<?php echo $cor_button; ?> btn-sm btnDesativar" type="button">
                            <i class="<?php echo $icon_button; ?>" aria-hidden="true"></i></button>
                        <?php
                        }
                        if ($podeEditar)
                        {
                        ?>
                        <button id="<?php echo $id ?>" class="btn btn-warning btn-sm btnEditar" type="button"
                            style="margin-top: 5px">
                            <i class="fa fa-edit" aria-hidden="true"></i></button>
                        <?php
                        }
                        ?>
                    </center>
                </td>
                <td>
                    <center><?php echo $id; ?></center>
                </td>
                <td>
                    <center><?php echo $nome; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $cpf; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $nascimento; ?></center>
                </td>
                <td>
                    <center><?php echo $empresa; ?></center>
                </td>
                <td>
                    <center><?php echo $perfil; ?></center>
                </td>
                <td>
                    <center>Tabela <?php echo $tabelaPadrao; ?></center>
                </td>
                <td>
                    <center><?php echo $comissao; ?>%</center>
                </td>
                <td>
                    <center><?php echo $modulosPermitidos; ?></center>
                </td>
                <td>
                    <center><?php echo $rua; ?></center>
                </td>
                <td>
                    <center><?php echo $numero; ?></center>
                </td>
                <td>
                    <center><?php echo $complemento; ?></center>
                </td>
                <td>
                    <center><?php echo $bairro; ?></center>
                </td>
                <td>
                    <center><?php echo $cidade; ?></center>
                </td>
                <td>
                    <center><?php echo $estado; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $login; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $email; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $telefone1; ?></center>
                </td>
                <td nowrap>
                    <center><?php echo $telefone2; ?></center>
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

<script src="js/consultas/CXESCAD003CON/CXESCAD003ACOES.js"></script>