<?php
try {
    // dados da conexao:
    $host = 'codegroup.mysql.dbaas.com.br';
    $database = 'codegroup';
    $db_user = 'codegroup';
    $db_password = 'Code@Group2021';
    $opcoes = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );

    // instancia a classe
    $conn = new PDO('mysql:host=' . $host . ';' . 'dbname=' . $database, $db_user, $db_password, $opcoes);

    $conn->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
} 
catch (PDOException $e) {
    //$e->getMessage();
    echo 'Não foi possível se conectar, tente novamente mais tarde.';
    exit();
}