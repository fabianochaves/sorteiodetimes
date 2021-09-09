/* JS DAS AÇÕES NO GRID DA CONSULTA DE CONFIRMAÇÕES */

$(document).ready(function () {

    controller = 0;

    jQuery('.encerrar').click(function () {

        var id = $(this).attr("id");

        $("#id_encerrar").val(id);
        $("#ModalEncerrar").modal("show");
    });

    jQuery('#confirma_encerrar').click(function () {

        $("#confirma_encerrar").attr("disabled", true);
        var carrega = document.getElementById('aguarde_encerrar');
        carrega.style.display = 'block';

        var id_encerrar = $("#id_encerrar").val();

        if (controller == 0) {
            jQuery.ajax({
                type: "POST",
                url: "processos/consulta-confirmacao/encerrar-gravar.php",
                async: false,
                data: { id: id_encerrar, },
                success: function (data) {
                    carrega.style.display = 'none';

                    if (data == "ok") {
                        controller = 1;
                        var ok = document.getElementById('sucesso_encerrar');
                        ok.style.display = 'block';
                        setTimeout(function () {
                            ok.style.display = 'none';
                            $("#confirma_encerrar").attr("disabled", false);
                            $("#ModalEncerrar").modal("hide");
                            window.location.reload();
                            return false;
                        }, 1500);
                        return false;
                    }
                    else {
                        $("#confirma_encerrar").attr("disabled", false);
                        var erro = document.getElementById('erro_encerrar');
                        erro.style.display = 'block';
                        setTimeout(function () {
                            erro.style.display = 'none';
                            return false;
                        }, 3000);
                    }
                    return false;
                }

            });
            return false;
        }
        else {
            carrega.style.display = 'none';
        }
        return false;

    });

    jQuery('.btnConfirmar').click(function () {

        var dados = ($(this).attr("id")).split('_');
        var id = dados[0];
        var nome = dados[1];
        var status = dados[2];
        var id_partida = dados[3];

        if (status == 0) {
            $("#titulo_header").empty();
            $("#titulo_header").text("Confirmar presença de Jogador");
            $("#texto_body").empty();
            $("#texto_body").text("Deseja confirmar a presença o Jogador?");
        }
        else {
            $("#titulo_header").empty();
            $("#titulo_header").text("Cancelar presença de Jogador");
            $("#texto_body").empty();
            $("#texto_body").text("Deseja cancelar a presença do Jogador?");
        }


        $("#id_confirmar").val(id);
        $("#status_confirmar").val(status);
        $("#partida_confirmar").val(id_partida);


        $("#dados_confirmar").empty();
        $("#dados_confirmar").append("<b>Jogador:</b> " + id + " - " + nome);

        $("#ModalConfirmar").modal("show");

        return false;
    });

    jQuery('#confirma_confirmar').click(function () {

        $("#confirma_confirmar").attr("disabled", true);
        var carrega = document.getElementById('aguarde_confirmar');
        carrega.style.display = 'block';

        var id_confirmar = $("#id_confirmar").val();
        var status_confirmar = $("#status_confirmar").val();
        var partida_confirmar = $("#partida_confirmar").val();

        if (controller == 0) {
            jQuery.ajax({
                type: "POST",
                url: "processos/consulta-confirmacao/consulta-confirmacao-gravar.php",
                async: false,
                data: { id: id_confirmar, status: status_confirmar, partida: partida_confirmar },
                success: function (data) {
                    carrega.style.display = 'none';

                    if (data == "ok") {
                        controller = 1;
                        var ok = document.getElementById('sucesso_confirmar');
                        ok.style.display = 'block';
                        setTimeout(function () {
                            ok.style.display = 'none';
                            $("#confirma_confirmar").attr("disabled", false);
                            $("#ModalConfirmar").modal("hide");
                            Filtrar();
                            return false;
                        }, 1500);
                        return false;
                    }
                    else {
                        $("#confirma_confirmar").attr("disabled", false);
                        var erro = document.getElementById('erro_confirmar');
                        erro.style.display = 'block';
                        setTimeout(function () {
                            erro.style.display = 'none';
                            return false;
                        }, 3000);
                    }

                    return false;
                }

            });
            return false;
        }
        else {
            carrega.style.display = 'none';
        }
        return false;

    });
});