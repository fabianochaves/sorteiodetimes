/* JS DO MODAL EDITAR DA CONSULTA DE USUÁRIO */
$(document).ready(function () {

    $('.chosen-select').chosen('destroy').chosen();

    jQuery('#confirma_editar').click(function () {
   
        $(".modal").animate({
            scrollTop: $("#confirma_editar").offset().top
        }, 200);

        var obrigatorios = true;

        $('.obrigatorios').each(function () {
            if ($(this).val() == '') {
                obrigatorios = false;
                return;
            }
        });

        if(obrigatorios == false)
        {
            return false;
        }

        $(this).empty();
        $(this).append("<img src='assets/images/gif/aguarde1.gif' style='width:40px; height: 40px;' />");

        $("#confirma_editar").attr("disabled", true);
        $("#cancela_editar").attr("disabled", true);

        var dados = $('#formulario').serialize();

        jQuery.ajax({
            type: "POST",
            url: "processos/consulta-usuario/consulta-usuario-gravaedit.php",
            data: dados,
            success: function (data) {
                setTimeout(function () {

                    $("#cancela_editar").attr("disabled", true);
                    $("#confirma_editar").empty();
                    $("#confirma_editar").append("Confirmar <i class='fa fa-check'></i>");

                    var exp = data.split('_');
                    var status = exp[0];
                    var mensagem = exp[1];

                    if (status == 'erro') {
                        $("#cancela_editar").attr("disabled", false);
                        $("#confirma_editar").attr("disabled", false);

                        $('#msg_erro').empty();
                        $('#msg_erro').text(mensagem);

                        var erro = document.getElementById('erro_editar');

                        erro.style.display = 'block';

                        setTimeout(function () {
                            erro.style.display = 'none';
                            return false;
                        }, 3000);

                        return false;
                    }
                    else if (status == 'ok') {
                        var sucesso = document.getElementById('sucesso_editar');

                        sucesso.style.display = 'block';

                        setTimeout(function () {
                            sucesso.style.display = 'none';
                            Filtrar();
                            $('#ModalEditar').modal('hide');
                            $("#cancela_editar").attr("disabled", false);
                            $("#confirma_editar").attr("disabled", false);
                            return false;
                        }, 2000);

                        return false;
                    }
                }, 2000);
            }
        });

        return false;
    });

});
