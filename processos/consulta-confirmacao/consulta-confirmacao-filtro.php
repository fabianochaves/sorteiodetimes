<?php
/* FILTRO CONSULTA DE CONFIRMAÇÃO */
date_default_timezone_set('America/Sao_Paulo');
session_start();

include('../../Connections/connpdo.php');
include('../../classes/Url.php');

$id_partida = $_POST['filtro'];

$busca = $conn->prepare("SELECT * FROM usuarios c WHERE status_usuario = 1");
try {
    $busca->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

$busca_dadosPartida = $conn->prepare("SELECT * FROM partidas WHERE id_partida = '$id_partida'");
try {
    $busca_dadosPartida->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

$row_dados = $busca_dadosPartida->fetch(PDO::FETCH_ASSOC);

$nro_jogadores = $row_dados['jogadoresTime_partida'];

$busca_confirmacoes = $conn->prepare("SELECT * FROM confirmacoes WHERE partida_confirmacao = '$id_partida'");
try {
    $busca_confirmacoes->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

$nro_confirmacoes = $busca_confirmacoes->rowCount();
?>

<div class="app-main__inner">
    <center>
        <p>Mínimo de Confirmados: <b><?php echo $nro_jogadores * 2; ?></b> / Jogadores Confirmados: <b><?php echo $nro_confirmacoes; ?></b></p>
    
    </center>
    <br>
    <table id="tab_grid" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>
                    <center>#</center>
                </th>
                <th>
                    <center>Confirmado</center>
                </th>
                <th>
                    <center>Nome</center>
                </th>
                <th>
                    <center>Nível</center>
                </th>
                <th>
                    <center>Goleiro</center>
                </th>
                <th>
                    <center>Telefone</center>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php

            while ($row = $busca->fetch(PDO::FETCH_ASSOC)) {
                $id_usuario = $row['id_usuario'];
                $nome = $row['nome_usuario'];
                $nivel = $row['nivel_usuario'];
                $goleiro = $row['goleiro_usuario'];
                $telefone = $row['telefone_usuario'];

                if ($goleiro == 1) {
                    $is_goleiro = "Sim";
                } else {
                    $is_goleiro = "Não";
                }

                $busca_confirmacao = $conn->prepare("SELECT * FROM confirmacoes 
                WHERE partida_confirmacao = '$id_partida' AND usuario_confirmacao = '$id_usuario'");
                try {
                    $busca_confirmacao->execute();
                } catch (PDOException $e) {
                    $e->getMessage();
                }

                if($busca_confirmacao->rowCount() > 0)
                {
                    $status = 1;
                    $nome_status = "Sim";
                    $cor_status = "green";
                    $cor_button = "danger";
                    $icon_button = "fa fa-close";
                    $text_button = "Cancelar";
                }
                else
                {
                    $status = 0;
                    $nome_status = "Não";
                    $cor_status = "red";
                    $cor_button = "success";
                    $icon_button = "fa fa-check";
                    $text_button = "Confirmar";
                }

            ?>
                <tr>
                    <td nowrap>
                        <center>

                            <button id="<?php echo $id_usuario . "_" . $nome . "_" . $status . "_" . $id_partida; ?>" class="btn btn-<?php echo $cor_button; ?> btn-sm btnConfirmar" type="button">
                                <i class="<?php echo $icon_button; ?>" aria-hidden="true"></i> <?php echo $text_button; ?>
                            </button>

                        </center>
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
                    <td>
                        <center><?php echo $nome; ?></center>
                    </td>
                    <td>
                        <center><?php echo $nivel; ?></center>
                    </td>
                    <td>
                        <center><?php echo $is_goleiro; ?></center>
                    </td>
                    <td nowrap>
                        <center><?php echo $telefone; ?></center>
                    </td>
                </tr>
            <?php

            }
            ?>
        </tbody>

    </table>
</div>

<script src="js/consultas/consulta-confirmacao/acoes-confirmar.js"></script>