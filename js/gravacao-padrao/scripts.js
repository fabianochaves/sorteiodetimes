$(this).ready(function () {

    $('.chosen-select').chosen('destroy').chosen();

    jQuery('#formulario').submit(function () {
        $("#btn_cadastrar").empty();
        $("#btn_cadastrar").append("<img src='assets/images/gif/aguarde1.gif' style='width:40px; height: 40px;' />");

        $("html, body").animate({
            scrollTop: $("#btn_cadastrar").offset().top
        }, 200);

        $("#btn_cadastrar").attr("disabled", true);

        var dados = jQuery(this).serialize();

        let obrigatorios = true;

        $('.obrigatorios').each(function () {
            if ($(this).val() == '') {
                obrigatorios = false;
                return;
            }
        });

        if (!obrigatorios) {
            setTimeout(function () {

                $("#btn_cadastrar").empty();
                $("#btn_cadastrar").append("<i class='fa fa-check-circle'></i> Salvar");

                $("#btn_cadastrar").attr("disabled", false);

                return false;

            }, 2000);

        }
        else {

            var pasta = $("#pasta_gravacao").val();
            var rotina = $("#rotina_gravacao").val();

            var url = "processos/"+pasta+"/"+rotina;

            jQuery.ajax({
                type: "POST",
                url: url,
                data: dados,
                success: function (data) {
                    setTimeout(function () {

                        $("#btn_cadastrar").empty();
                        $("#btn_cadastrar").append("<i class='fa fa-check-circle'></i> Salvar");

                        var exp = data.split('_');
                        var status = exp[0];
                        var mensagem = exp[1];

                        if (status == 'erro') {

                            $("#btn_cadastrar").attr("disabled", false);

                            $('#msg_erro').empty();
                            $('#msg_erro').text(mensagem);

                            var erro = document.getElementById('erro');
                            erro.style.display = 'block';

                            setTimeout(function () {
                                erro.style.display = 'none';
                                return false;
                            }, 3000);
                            return false;
                        }
                        else if (status == 'ok') {
                            $('#cod_gerado').empty();
                            $('#cod_gerado').text(mensagem);

                            var sucesso = document.getElementById('sucesso');

                            sucesso.style.display = 'block';

                            setTimeout(function () {
                                sucesso.style.display = 'none';
                                window.location.reload();
                                return false;
                            }, 2000);

                            return false;
                        }

                    }, 2000);
                }
            });
            return false;
        }
    });
});
