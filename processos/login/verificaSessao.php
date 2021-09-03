<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

$result = array();

$tempoRestante = $_SESSION['sessiontime'] - time();

if (isset($_SESSION['sessiontime']))
    $result['ok'] = $tempoRestante > 0;
else
    $result['ok'] = false;

if ($result['ok'] == false)
    $_SESSION["sessiontime"] = 0;

if (isset($_SESSION['sessiontime']))
    $result['tempoRestante'] = $tempoRestante;

echo json_encode($result);
return false;
?>