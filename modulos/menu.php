<?php
date_default_timezone_set('America/Sao_Paulo');
include('Connections/connpdo.php');
require_once ("classes/TempoSessao.php");

if(!isset($_SESSION['user']))
{
    header("location: 403"); 
}
else
{
    $usuario = $_SESSION['user'];
    TempoSessao::atualizar();   
}
?>

<link href="./main.css" rel="stylesheet">
<script type="text/javascript" src="./js/validarform.js"></script>
<style>
.bs-example {
    margin: 20px;
}
</style>
<link rel="shortcut icon" href="assets/images/favicon.ico" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<link href="js/jquery3.4.1.js" rel="stylesheet">

<script src="js/bootstrap.bundle.min.js" type="text/javascript" charset="utf-8"></script>

<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>


<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button id="btnHambuger" type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a id="btnMenuUsuario" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="p-0 btn"><img width="42" class="rounded-circle" src="assets/images/avatars/avatar.png" alt=""><i class="fa fa-angle-down ml-2 opacity-8"></i></a>
                                <div id="menuDropdownUsuario" tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                    <a href="alterarsenha" tabindex="0" class="dropdown-item">Alterar Senha</a>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <a href="logout" tabindex="0" class="dropdown-item">Sair</a>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                <?php echo $_SESSION['nome']; ?>
                            </div>
                            <div class="widget-subheading">
                                <?php echo $_SESSION['nome_sistema']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="app-main">
    <div class="app-sidebar sidebar-shadow">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div id="menuModulosSelect" class="scrollbar-sidebar" style="overflow-y: scroll">
        <div class="app-sidebar__inner">
            <?php 
            $considerar_permissoes = true;
            include('processos/menu/obterMenu.php');
            ?>
        </div>
    </div>
</div>

<?php
include("Connections/connpdo.php");

if(!isset($_SESSION['user']))
{
    header("location: logout.php");
}
else
{
    $usuario = $_SESSION['user'];
    $perfil = $_SESSION['perfil'];
    $busca_user = $conn->prepare("SELECT * FROM usuarios WHERE id = '$usuario' AND status = 1");
    try {
        $busca_user->execute();
    } 
    catch (PDOException $e) {
        $e->getMessage();
    }
    
    $row_user = $busca_user->fetch(PDO::FETCH_ASSOC);
}

?>
<link href="./main.css" rel="stylesheet">
<script type="text/javascript" src="./js/validarform.js"></script>

<style>
.bs-example {
    margin: 20px;
}

@media (max-width: 991.98px) {
    .dropdown-menu {
        top: 210px !important;
    }
}
</style>


<link href="css/fontawesome4.7.0.css" rel="stylesheet">
<link href="js/jquery3.4.1.js" rel="stylesheet">
<script src="js/bootstrap.bundle.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="assets/scripts/main_menu.js"></script>
<script type="text/javascript" src="assets/scripts/scripts_menu.js"></script>