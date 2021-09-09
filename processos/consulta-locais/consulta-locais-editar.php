<?php
include("../../Connections/connpdo.php");
date_default_timezone_set('America/Sao_Paulo');

$id = $_POST['id'];

$busca = $conn->prepare("SELECT * FROM locais WHERE id_local = $id");

try 
{
    $busca->execute();
} 
catch (PDOException $e) 
{
    $e->getMessage();
}

$row = $busca->fetch(PDO::FETCH_ASSOC);

$nome = $row['nome_local'];

?>

<form class="needs-validation offset-md-12 col-md-12 " name="formulario" id="formulario" method="POST" novalidate>
    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

    <br>
   
    <div class="form-row">
        <div class="col-md-8">
            <label class="label_titulos">Nome</label>
            <input autocomplete="off" type="text" name="nome" id="nome" style="height: 34px;"
                class="form-control obrigatorios" value="<?php echo $nome; ?>" required />
            <div class="valid-feedback">
                Ok!
            </div>
            <div class="invalid-feedback">
                Preencha o Nome!
            </div>
        </div>
    </div>
</form>

<script src="js/consultas/consulta-locais/acoes-editar.js"></script>