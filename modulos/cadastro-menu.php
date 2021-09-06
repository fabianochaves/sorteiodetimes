<?php
/* CADASTRO DE MENU */
include("Connections/connpdo.php");
$pasta_gravacao = "cadastro-menu";
$rotina_gravacao = "cadastro-menu-gravar.php";
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['nome_sistema']; ?> | Cadastro de Menu</title>

    <?php include("processos/head-padrao/headers.php"); ?>

    <script type="text/javascript" src="js/cadastro-menu/funcoes.js"></script>
    <script type="text/javascript" src="js/gravacao-padrao/scripts.js"></script>


</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include("menu.php"); ?>
        <div class="app-main__outer">
            <div class="app-main__inner" style="margin-top: -25px;">
                <div class="app-page-title" style="height: 95px;">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                                <i class="pe-7s-albums icon-gradient bg-mean-fruit"></i>
                            </div>
                            <div>Cadastro de Menu/Módulo
                                <div class="page-title-subheading">
                                    Menu
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="main-card mb-3 card col-md-6 offset-md-3">

                    <div class="card-body">
                        <h5 class="card-title col-md-12 col text-center">Cadastro de Menu/Módulo</h5>

                        <div class="col-md-12 col text-left">
                            <form class="needs-validation offset-md-12 col-md-12 " name="formulario" id="formulario"
                                method="POST" novalidate>
                                <br>
                                <input type="hidden" name="pasta_gravacao" id="pasta_gravacao" value="<?php echo $pasta_gravacao; ?>" />
                                <input type="hidden" name="rotina_gravacao" id="rotina_gravacao" value="<?php echo $rotina_gravacao; ?>" />
                                <div class="form-row">
                                    <div id="div_tipo" class="col-md-8">
                                        <label class="label_titulos">Tipo</label>
                                        <select data-placeholder="Escolha o Tipo..." name="tipo" id="tipo"
                                            class="form-control obrigatorios chosen-select" tabindex="2" required>
                                            <option value="">Escolha o Tipo...</option>
                                            <option selected value="0">Menu</option>
                                            <option value="1">Módulo</option>
                                        </select>
                                        <div class="valid-feedback">
                                            Ok!
                                        </div>
                                        <div class="invalid-feedback">
                                            Preencha o Tipo!
                                        </div>
                                    </div>
                                    <div id='div_rotina' class="col-md-4" style="display: none">
                                        <label class="label_titulos">Rotina</label>
                                        <input autocomplete="off" type="text" name="rotina" id="rotina"
                                            style="height: 34px;" class="form-control" value="" />
                                        <div class="valid-feedback">
                                            Ok!
                                        </div>
                                        <div class="invalid-feedback">
                                            Preencha a Rotina!
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <label class="label_titulos">Nome</label>
                                        <input autocomplete="off" type="text" name="nome" id="nome"
                                            style="height: 34px;" class="form-control obrigatorios somenteLetras"
                                            value="" required />
                                        <div class="valid-feedback">
                                            Ok!
                                        </div>
                                        <div class="invalid-feedback">
                                            Preencha o Nome!
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="label_titulos">Ícone</label>
                                        <input autocomplete="off" type="text" name="icone" id="icone"
                                            style="height: 34px;" class="form-control" value="fa fa-list" />
                                        <div class="valid-feedback">
                                            Ok!
                                        </div>
                                        <div class="invalid-feedback">
                                            Preencha o Ícone!
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label class="label_titulos">Menu</label>
                                        <select data-placeholder="Escolha o Menu..." name="menu" id="menu"
                                            class="form-control obrigatorios chosen-select" tabindex="2" required>
                                            <option value="">Escolha o Menu...</option>
                                            <option selected value="0">Principal</option>
                                            <?php
                                            $menus = $conn->prepare(
                                                "SELECT id_menu,nome_menu,menu_menu FROM menus 
                                                WHERE tipo_menu = 0 AND 
                                                status_menu=1 ORDER BY menu_menu ASC
                                                ");

                                            try 
                                            {
                                                $menus->execute();
                                            } 
                                            catch (PDOException $e) 
                                            {
                                                $e->getMessage();
                                            }

                                            $menus_arr = array();

                                            while($row = $menus->fetch(PDO::FETCH_ASSOC))
                                            {
                                                $menus_arr[$row['id_menu']] = $row;
                                            }

                                            foreach ($menus_arr as $key => &$menu)
                                            {
                                                $id_menu = $key;
                                                $nome_menu = $menu['nome_menu'];

                                                if ($menu['menu_menu'] == 0)
                                                {
                                                    $nome_menu = 'Principal/'.$nome_menu;
                                                }

                                                if ($menu['menu_menu'] > 0)
                                                {
                                                    $ultimo_menu = $menu['menu_menu'];

                                                    while ($ultimo_menu > 0)
                                                    {
                                                        if (!array_key_exists($ultimo_menu, $menus_arr))
                                                        {
                                                            break;
                                                        }

                                                        $nome_menu = $menus_arr[$ultimo_menu]['nome_menu']."/".$nome_menu;
                                                        $ultimo_menu = $menus_arr[$ultimo_menu]['menu_menu'];
                                                    }

                                                    if ($ultimo_menu > 0)
                                                    {
                                                        continue;
                                                    }

                                                    $nome_menu = 'Principal/'.$nome_menu;
                                                }

                                                echo "<option value=\"$id_menu\">$nome_menu</option>";
                                            }
                                        ?>
                                        </select>
                                        <div class="valid-feedback">
                                            Ok!
                                        </div>
                                        <div class="invalid-feedback">
                                            Preencha o Menu!
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="form-row">
                                    <div class="col-md-8 offset-md-2">
                                        <center>
                                            <div class="alert alert-danger" role="alert" id="erro"
                                                style="display:none;">
                                                <center><b><span id="msg_erro"></span></b></center>
                                            </div>

                                            <div class="alert alert-success" role="alert" id="sucesso"
                                                style="display:none;">
                                                <center><b>Cadastro <span id="cod_gerado"></span> salvo com Sucesso!</b>
                                                </center>
                                            </div>
                                        </center>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4 offset-md-4">

                                        <center><img id="aguarde"
                                                src="<?php echo URL::getBase(); ?>assets/images/gif/loading.gif"
                                                style="width: 120px; height: 120px; display:none;" /></center>

                                        <button class="btn btn-success col-md-12" id="btn_cadastrar" type="submit"><i
                                                class="fa fa-check-circle" aria-hidden="true"></i> Salvar</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
