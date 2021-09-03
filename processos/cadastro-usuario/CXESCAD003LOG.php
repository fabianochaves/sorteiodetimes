<?php
require('../../classes/Formatters.php');
require('../../classes/logs/TabelaInfo.php');
require('../../classes/logs/ILog.php');
require('../../classes/logs/GravaLog.php');
require('../../classes/logs/LogCadastro.php');
require('../../classes/logs/LogAlteracao.php');
require('../../classes/logs/LogStatus.php');

session_start();

class Informacoes
{
    const ROTINA = 'CXESCAD003';
}

function obterTabelaInfo($conn)
{
    $queryParaObterRegistro = 
        'SELECT 
        nome_usuario, cpf_usuario, nascimento_usuario, cep_usuario, 
        rua_usuario, nro_usuario, comp_usuario, bairro_usuario, 
        cidade_usuario, estado_usuario, telefone1_usuario, telefone2_usuario, 
        email_usuario, login_usuario, tabela_usuario, comissao_usuario, modulos_perm_usuario, nome_empresa, nome_perfil 
        FROM usuarios u 
        LEFT JOIN empresas e on e.id_empresa = u.empresa_usuario 
        LEFT JOIN perfis p ON p.id_perfil = u.perfil_usuario 
        WHERE id_usuario = ?';

    $tabelaInfo = new TabelaInfo($conn, $queryParaObterRegistro);

    $tabelaInfo->adicionarColuna('nome_usuario', 'Nome', false, true);
    $tabelaInfo->adicionarColuna('cpf_usuario', 'CPF', false, true);
    $tabelaInfo->adicionarColuna('nascimento_usuario', 'Nascimento', new ValueFormatDate());
    $tabelaInfo->adicionarColuna('nome_empresa', 'Empresa Padrão');
    $tabelaInfo->adicionarColuna('nome_perfil', 'Perfil');
    $tabelaInfo->adicionarColuna('tabela_usuario', 'Tabela Padrão');
    $tabelaInfo->adicionarColuna('comissao_usuario', 'Comissão');
    $tabelaInfo->adicionarColuna('modulos_perm_usuario', 'Módulos Permitidos');
    $tabelaInfo->adicionarColuna('regiao_usuario', 'Região');
    $tabelaInfo->adicionarColuna('cep_usuario', 'CEP');
    $tabelaInfo->adicionarColuna('rua_usuario', 'Rua');
    $tabelaInfo->adicionarColuna('nro_usuario', 'Número');
    $tabelaInfo->adicionarColuna('comp_usuario', 'Complemento');
    $tabelaInfo->adicionarColuna('bairro_usuario', 'Bairro');
    $tabelaInfo->adicionarColuna('cidade_usuario', 'Cidade');
    $tabelaInfo->adicionarColuna('estado_usuario', 'Estado');
    $tabelaInfo->adicionarColuna('telefone1_usuario', 'Telefone 1');
    $tabelaInfo->adicionarColuna('telefone2_usuario', 'Telefone 2');
    $tabelaInfo->adicionarColuna('email_usuario', 'E-mail');
    $tabelaInfo->adicionarColuna('login_usuario', 'Login');

    return $tabelaInfo;
}

function obterLogCadastro($conn, $registroID)
{
    $tabelaInfo = obterTabelaInfo($conn);
    $usuarioID = $_SESSION['user'];

    $logCadastro = new LogCadastro($conn, $usuarioID, Informacoes::ROTINA, $tabelaInfo, $registroID);

    return $logCadastro;
}

function obterLogAlteracao($conn, $registroID)
{
    $tabelaInfo = obterTabelaInfo($conn);
    $usuarioID = $_SESSION['user'];
    
    $logAlteracao = new LogAlteracao($conn, $usuarioID, Informacoes::ROTINA, $tabelaInfo, $registroID);

    return $logAlteracao;
}

function obterLogStatus($conn, $registroID, $statusAntigo, $statusNovo)
{
    $usuarioID = $_SESSION['user'];
    
    $logStatus = new LogStatus($conn, $usuarioID, Informacoes::ROTINA, $registroID);
    $logStatus->atribuirStatus($statusAntigo, $statusNovo);

    return $logStatus;
}
?>