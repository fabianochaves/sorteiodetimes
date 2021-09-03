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
    const ROTINA = 'CXESCAD042';
}

function obterTabelaInfo($conn)
{
    $queryParaObterRegistro = 
        'SELECT * FROM menus WHERE id_menu = ?';

    $tabelaInfo = new TabelaInfo($conn, $queryParaObterRegistro);

    $tabelaInfo->adicionarColuna('tipo_menu', 'Tipo', new ValueFormatTipoMenu(), true);
    $tabelaInfo->adicionarColuna('rotina_menu', 'Rotina', false, true);
    $tabelaInfo->adicionarColuna('nome_menu', 'Nome', false, true);
    $tabelaInfo->adicionarColuna('icone_menu', 'Ícone');
    $tabelaInfo->adicionarColuna('menu_menu', 'Menu', new ValueFormatMenu($conn), true);

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

// Formatters customizados

class ValueFormatTipoMenu extends IValueFormat
{
    public function format($value)
    {
        if ($value == '0')
        {
            return 'Menu';
        }
        else
        {
            return 'Módulo';
        }
    }
}

class ValueFormatMenu extends IValueFormat
{
    private $conn;
    
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    public function format($value)
    {
        $descricao = '';

        if ($value == 0)
        {
            $descricao = 'Principal';
        }
        else
        {
            $busca = 
            $this->conn->prepare("
                SELECT nome_menu 
                FROM menus 
                WHERE id_menu = '$value'
            ");
        
            try {
                $busca->execute();
            } 
            catch (PDOException $e) {
                $e->getMessage();
            }

            if ($row = $busca->fetch(PDO::FETCH_ASSOC))
            {
                $descricao = utf8_encode($row['nome_menu']);
            }
        }

        return $descricao;
    }
}
?>