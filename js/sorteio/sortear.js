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

            if(data == "existe")
            {
                var existe = document.getElementById('existe_sorteio');
                existe.style.display = 'block';
                    setTimeout(function () {
                        existe.style.display = 'none';
                        window.location.reload();
                        return false;
                    }, 3000);
                    return false;
            }
            else
            {
                $("#resultado_grid").empty();
                $("#resultado_grid").html(data);
                return false;
            }

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