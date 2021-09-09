<?php
/* LÓGICA DO SORTEIO */
date_default_timezone_set('America/Sao_Paulo');
session_start();
$user = $_SESSION['user'];
$datetime = date("Y-m-d H:i:s");
include('../../Connections/connpdo.php');
include('../../classes/Url.php');

$exp = explode("_", $_POST['filtro']);
$id_partida = $exp[0];
$nro_jogadores = $exp[1];

//DELETA SORTEIOS ANTERIORES
$delete = $conn->prepare("DELETE FROM sorteio_distribuicao WHERE partida_distribuicao = '$id_partida'");
try {
    $delete->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

$busca_confirmacoes = $conn->prepare("SELECT * FROM confirmacoes WHERE partida_confirmacao = '$id_partida'");
try {
    $busca_confirmacoes->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

$nro_confirmacoes = $busca_confirmacoes->rowCount();

$times = $nro_confirmacoes / $nro_jogadores;

if (is_int($times)) {
    $times_completos = $times;
    $jogadores_incompleto = 0;
    $total_times = $times_completos;
} else {
    $exp = explode(".", $times);
    $times_completos = $exp[0];
    $jogadores_incompleto = $nro_confirmacoes % $nro_jogadores;
    $total_times = $times_completos + 1;
}


//GRAVA SORTEIO
$grava_sorteio = $conn->prepare("
INSERT INTO sorteios(partida_sorteio,user_sorteio,datahora_sorteio)
VALUES('$id_partida','$user','$datetime')
");
try {
    $grava_sorteio->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

$id_sorteio = $conn->lastInsertId();

$array_goleiros = [];
$goleiros_selecionados = "";

//for para buscar os goleiros dos times
for ($g = 1; $g <= $total_times; $g++) {

    if ($g == 1) {
        $goleiros_selecionados = "";
    }

    $busca_goleiro = $conn->prepare("
        SELECT * FROM confirmacoes c
        INNER JOIN usuarios u ON (u.id_usuario = c.usuario_confirmacao)
        WHERE partida_confirmacao = '$id_partida' $goleiros_selecionados AND goleiro_usuario = 1 ORDER BY RAND() LIMIT 1");
    try {
        $busca_goleiro->execute();
    } catch (PDOException $e) {
        $e->getMessage();
    }
    if ($busca_goleiro->rowCount() > 0) {

        $row_goleiro = $busca_goleiro->fetch(PDO::FETCH_ASSOC);
        $id_goleiro = $row_goleiro['id_usuario'];

        if (count($array_goleiros) <= $times_completos) {
            $array_goleiros[$g] = $id_goleiro;
            Gravar($conn, $id_sorteio, $id_partida, $id_goleiro, 1, $g);
        }
    }

    //CONFIGURAÇÃO PARA O SQL BUSCAR GOLEIROS AINDA NÃO SELECIONADOS
    if (count($array_goleiros) > 0) {
        $config_selecao = implode(",", $array_goleiros);
        $goleiros_selecionados = "AND id_usuario NOT IN (" . $config_selecao . ")";
    }
}


$busca_confirmados = $conn->prepare("
SELECT * FROM confirmacoes c
INNER JOIN usuarios u ON (u.id_usuario = c.usuario_confirmacao)
WHERE partida_confirmacao = '$id_partida' $goleiros_selecionados ORDER BY nivel_usuario,rand() DESC");
try {
    $busca_confirmados->execute();
} catch (PDOException $e) {
    $e->getMessage();
}

$cont = 1;
$cont_incompletos = 0;

while ($row_confirmados = $busca_confirmados->fetch(PDO::FETCH_ASSOC)) {

    $id_jogador = $row_confirmados['id_usuario'];

    $qtd_jogadores = qtdJogadores($conn, $cont);



    //TIME SEM VAGA
    if($qtd_jogadores == $nro_jogadores) {

        //OUTRO TIME
        for ($i = 1; $i <= $total_times -1; $i++) {

            $qtd_jogadores = qtdJogadores($conn, $i);

            //AINDA EXISTE VAGA
            if ($qtd_jogadores < $nro_jogadores) {

                Gravar($conn, $id_sorteio, $id_partida, $id_jogador, 0, $i);
                $cont++;
            }

            break;
            
        }
    } else {

        //ULTIMO TIME DA LISTA
        if ($cont == $total_times) {
           
            if($jogadores_incompleto > 0)
            {
                if($qtd_jogadores < $jogadores_incompleto)
                {
                    Gravar($conn, $id_sorteio, $id_partida, $id_jogador, 0, $cont);
                    $cont_incompletos++;
                }
                else{
                   //OUTRO TIME
                   $flag = 0;
                    for ($i = 1; $i <= $total_times -1; $i++) {

                        if($flag == 0)
                        {
                            $qtd_jogadores = qtdJogadores($conn, $i);

                            //AINDA EXISTE VAGA
                            if ($qtd_jogadores < $nro_jogadores) {
    
                                Gravar($conn, $id_sorteio, $id_partida, $id_jogador, 0, $i);
                                $flag = 1;
                 
                            }
                        }

                        
                    } 
                }
            }
            else{
                Gravar($conn, $id_sorteio, $id_partida, $id_jogador, 0, $cont);  
            }

            
            $cont = 1;
        } else {

            Gravar($conn, $id_sorteio, $id_partida, $id_jogador, 0, $cont);
            $cont++;
        }
    }
}

for ($t = 1; $t <= $total_times; $t++) {
    $busca_times = $conn->prepare("
    SELECT * FROM sorteio_distribuicao sd
    INNER JOIN usuarios u ON (sd.jogador_distribuicao = u.id_usuario)
    WHERE codSorteio_distribuicao = '$id_sorteio' AND time_distribuicao = '$t'
        ");
    try {
        $busca_times->execute();
    } catch (PDOException $e) {
        $e->getMessage();
    }

?>
    <center>
        <p><b><font color='blue'>Time <?php echo $t; ?></font></b></p>
    </center>
    <table class="table table-bordered" style="width: 100%">
        <tr>
            <td><center><b>Jogador</b></center></td>
            <td><center><b>Nível</b></center></td>
        </tr>
        <?php

        $soma_nivel = 0;
        while ($row_times = $busca_times->fetch(PDO::FETCH_ASSOC)) {

            $id_jogador = $row_times['id_usuario'];
            $nome_jogador = $row_times['nome_usuario'];
            $nivel_jogador = $row_times['nivel_usuario'];
            $is_goleiro = $row_times['goleiro_distribuicao'];
            if($is_goleiro == 1)
            {
                $goleiro = "<font color='green'><i class='fa fa-check'></i></font>";
            }
            else{
                $goleiro = "";
            }

            $soma_nivel += $nivel_jogador;
        ?>
            <tr>
                <td><center><?php echo $nome_jogador . " " . $goleiro; ?></center></td>
                <td><center><?php echo $nivel_jogador; ?></center></td>
            </tr>
        <?php
        }
        ?>
        <tfoot>
            <tr>
                <td align="right">Nível do Time: </td>
                <td><?php echo $soma_nivel; ?> </td>
            </tr>
        </tfoot>
    </table>
<?php
}

function Gravar($conn, $id_sorteio, $id_partida, $id_jogador, $goleiro_jogador, $time)
{

    $grava_escolha = $conn->prepare("
    INSERT INTO sorteio_distribuicao(codSorteio_distribuicao, partida_distribuicao,jogador_distribuicao,goleiro_distribuicao,time_distribuicao)
    VALUES('$id_sorteio', '$id_partida,','$id_jogador','$goleiro_jogador','$time')
    ");
    try {
        $gravacao = $grava_escolha->execute();
    } catch (PDOException $e) {
        $gravacao = $e->getMessage();
    }

    return $gravacao;
}

function qtdJogadores($conn, $time)
{

    $busca = $conn->prepare("
        SELECT * FROM sorteio_distribuicao WHERE time_distribuicao = '$time'
    ");
    try {
        $busca->execute();
    } catch (PDOException $e) {
        $e->getMessage();
    }

    return $busca->rowCount();
}

?>

<div class="app-main__inner">

</div>