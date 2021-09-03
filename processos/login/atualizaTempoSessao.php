<?php
require ('../../classes/TempoSessao.php');

TempoSessao::atualizar();

$resposta = array('ok' => true);

echo json_encode($resposta);
return false;
?>