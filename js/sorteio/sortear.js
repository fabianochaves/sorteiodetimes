/* JS Sorteio */

function Sortear() {

    $("#resultado_grid").empty();

    $("#aguarde").attr("style", "display: block; width: 120px; height: 120px;");

    var dados = $("#form_filtro").serialize();

    jQuery.ajax({
        type: "POST",
        url: "processos/sorteio/sortear.php",
        data: dados,
        success: function (data) {

            $("#aguarde").attr("style", "display: none");
            $("#resultado_grid").empty();
            $("#resultado_grid").html(data);
            return false;
        }
    });
    return false;


}

jQuery(document).ready(function () {

    jQuery('#btn_filtro').click(function () {

        if($("#filtro").val() == ""){
            return false;
        }
        else{
            Sortear();
        }
        
    });
   

});