<?php
include("../../Connections/connpdo.php");
date_default_timezone_set('America/Sao_Paulo');

$id = $_POST['id'];

$busca = $conn->prepare("SELECT * FROM menus WHERE id_menu = $id");

try 
{
    $busca->execute();
} 
catch (PDOException $e) 
{
    $e->getMessage();
}

$row = $busca->fetch(PDO::FETCH_ASSOC);

$tipo = $row['tipo_menu'];
$nome = $row['nome_menu'];
$rotina = $row['rotina_menu'];              
$icone = $row['icone_menu'];
$menu_menu = $row['menu_menu'];
?>

<form class="needs-validation offset-md-12 col-md-12 " name="formulario" id="formulario" method="POST" novalidate>
    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" id="tipo" name="tipo" value="<?php echo $tipo; ?>" />
    <br>
    <div class="form-row">
        <div class="<?php echo $tipo == 0 ? 'col-md-12' : 'col-md-8'; ?>">
            <label class="label_titulos">Tipo</label>
            <input autocomplete="off" type="text" name="lbltipo" id="lbltipo" style="height: 34px;" class="form-control"
                value="<?php echo $tipo == '1' ? 'Módulo' : 'Menu'; ?>" disabled />
        </div>
        <div id='div_rotina' class="col-md-4" style=" <?php if ($tipo == 0) echo 'display: none'; ?>">
            <label class="label_titulos">Rotina</label>
            <input autocomplete="off" type="text" name="rotina" id="rotina" style="height: 34px;" class="form-control"
                value="<?php echo $rotina; ?>" />
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
            <input autocomplete="off" type="text" name="nome" id="nome" style="height: 34px;"
                class="form-control obrigatorios somenteLetras" value="<?php echo $nome; ?>" required />
            <div class="valid-feedback">
                Ok!
            </div>
            <div class="invalid-feedback">
                Preencha o Nome!
            </div>
        </div>
        <div class="col-md-4">
            <label class="label_titulos">Ícone</label>
            <input autocomplete="off" type="text" name="icone" id="icone" style="height: 34px;" class="form-control"
                value="<?php echo $icone; ?>" />
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

                    $selected = $menu_menu == $key ? 'selected' : '';
                    echo "<option $selected value=\"$id_menu\">$nome_menu</option>";
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
</form>

<script src="js/consultas/consulta-menu/acoes-editar.js"></script>