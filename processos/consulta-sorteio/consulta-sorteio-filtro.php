<?php
/* FILTRO CONSULTA DE TIMES DO SORTEIO */
date_default_timezone_set('America/Sao_Paulo');
session_start();

include('../../Connections/connpdo.php');
include('../../classes/Url.php');

$id_sorteio = $_POST['filtro'];

$busca = $conn->prepare("
SELECT * FROM sorteio_distribuicao sd
INNER JOIN usuarios u ON (u.id_usuario = sd.jogador_distribuicao) 
WHERE codSorteio_distribuicao = '$id_sorteio' ORDER BY time_distribuicao,goleiro_distribuicao DESC");
try {
    $busca->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

?>

<div class="app-main__inner">
  
    <a href="#"  class="download">
        <button class="btn btn-warning gerar_imagem" type="button" id="<?php echo $id_sorteio; ?>">Gerar Imagem <i class="fa fa-camera"></i></button>
    </a>
    <br>
    <div id="lista_times">
        <br>
        <?php
      
        $query = $conn->prepare("
        SELECT * FROM partidas p 
        INNER JOIN locais l ON (l.id_local = p.local_partida)
        WHERE sorteio_partida = '$id_sorteio'
        ");

        try {
            $query->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }

        $row = $query->fetch(PDO::FETCH_ASSOC);

        echo "<center><b>JOGO: " . $row['nome_local'] . " | " . date("d/m/Y", strtotime($row['data_partida'])) . " | " . $row['hora_partida'] . "</b></center>";
        ?>
        </br>

        <table id="tab_grid" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <td>
                        <center>Ordem</center>
                    </td>
                    <td>
                        <center>Nome</center>
                    </td>
                    <td>
                        <center>Goleiro</center>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php
                $cont = 0;
                $cont_jogadores = 1;
                while ($row = $busca->fetch(PDO::FETCH_ASSOC)) {

                    if ($cont == 0) {
                        $cont++;
                ?>
                        <tr>
                            <td colspan="3">
                                <center><b>Time <?php echo $cont; ?></b></center>
                            </td>

                        </tr>
                    <?php

                    }

                    $id_usuario = $row['id_usuario'];
                    $nome = $row['nome_usuario'];
                    $nivel = $row['nivel_usuario'];
                    $goleiro = $row['goleiro_usuario'];
                    $time = $row['time_distribuicao'];

                    if ($time > $cont) {
                        $cont = $time;
                        $cont_jogadores = 1;
                    ?>
                        <tr>
                            <td colspan="3">
                                <center><b>Time <?php echo $cont; ?></b></center>
                            </td>

                        </tr>
                    <?php
                    }

                    if ($goleiro == 1) {
                        $is_goleiro = "Sim";
                    } else {
                        $is_goleiro = "Não";
                    }

                    ?>
                    <tr>
                        <td>
                            <center><?php echo $cont_jogadores; ?></center>
                        </td>
                        <td>
                            <center><?php echo $nome; ?></center>
                        </td>
                        <td>
                            <center><?php echo $is_goleiro; ?></center>
                        </td>
                    </tr>
                <?php
                    $cont_jogadores++;
                }
                ?>
            </tbody>

        </table>
    </div>
</div>

<script src="js/consultas/consulta-sorteio/imprimir.js"></script>