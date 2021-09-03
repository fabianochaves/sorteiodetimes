<?php
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
session_start();
require ('Connections/connpdo.php');
require ("classes/Url.php");
require ("classes/UltimaRotinaAcessada.php");
require_once ("classes/TempoSessao.php");

$modulo = Url::getURL( 0 );
$ultimaRotinaAcessada = new UltimaRotinaAcessada(false, false);

//validação do tempo de sessão ativa
if (isset( $_SESSION["sessiontime"] ) ) 
{ 
	if ($_SESSION["sessiontime"] < time()) 
	{
		$ultimaRotinaAcessada->reabrirAoLogar();
		session_destroy();
		require "modulos/440.php";
		exit();
		//header("location: "); 
	} 
	else
	{
		TempoSessao::atualizar();
		$ultimaRotinaAcessada = new UltimaRotinaAcessada($conn, $_SESSION['user']);
	}
} 
else
{ 
	session_destroy();
	header("location: ");      
}
?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">

    <link rel="icon" type="image/png" href="assets/images/favicon.png" />
</head>

<?php 
include('processos/menu/verificarPermissao.php');

if( $modulo == null )
{
	require "/login";
}
else
{
	if( file_exists( "modulos/" . $modulo . ".php" ) )
	{
		$possui_permissao = VerificarPermissao($modulo);

		if ($possui_permissao)
		{
			if ($modulo == 'inicio')
			{
				$ultimaRotina = $ultimaRotinaAcessada->obter();
				
				if ($ultimaRotina !== false)
				{
					if ($ultimaRotina['reabrir_ultima_rotina'] == true)
					{
						$ultimaRotinaAcessada->naoReabrirAoLogar();

						$rotinaAcessadaQuantoTempoAtrasEmMinutos = 
							((time() - strtotime($ultimaRotina['data_ultima_rotina'])) / 60);

						if ($rotinaAcessadaQuantoTempoAtrasEmMinutos <= 30)
						{
							$ultimaRotina = $ultimaRotina['nome_ultima_rotina'];
							header("location: $ultimaRotina"); 	
							exit();
						}
					}
				}
			}
			else if (!in_array($modulo, obterExcessoes()))
			{
				$ultimaRotinaAcessada->salvar($modulo);
			}

			require "modulos/" . $modulo . ".php";
		}
		else
		{
			$ultimaRotinaAcessada->reabrirAoLogar();
			require "modulos/403.php";
		}		
	}
	else
	{
		if ($modulo != 'processos' && $modulo != 'js')
			$ultimaRotinaAcessada->reabrirAoLogar();
			
		require "modulos/404.php";
	}
}
?>

<script src="js/redrawElements.js"></script>

<?php
if ($modulo != 'login')
{
	echo '<script src="js/verificaSessao.js"></script>';
	echo '<script src="js/atualizaTempoSessao.js"></script>';
}
?>