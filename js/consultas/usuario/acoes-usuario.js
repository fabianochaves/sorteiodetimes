/* CXESCAD003CONACOES - JS DAS AÇÕES NO GRID DA CONSULTA DE USUÁRIO */

$(document).ready(function () {

    jQuery('.btnEditar').click(function () {
        var id = ($(this).attr("id"));

        $("#id_editar").val(id);

        jQuery.ajax({
            type: "POST",
            url: "processos/CXESCAD003CON/CXESCAD003EDIT.php",
            data: { id: id },
            success: function (data) {
                $("#dados_editar").empty();
                $("#dados_editar").append(data);

                $("#ModalEditar").modal("show");

                return false;
            }

        });

        return false;
    });

    jQuery('.btnDesativar').click(function () {
        var dados = ($(this).attr("id")).split('_');
        var id = dados[0];
        var nome = dados[1];
        var status = dados[2];

        $("#id_desativar").val(id);
        $("#status_desativar").val(status);

        $("#dados_desativar").empty();
        $("#dados_desativar").append("<b>Usuário:</b> " + id + " - " + nome);

        $("#ModalDesativar").modal("show");

        return false;
    });

    jQuery('#confirma_desativar').click(function () {
        $("#confirma_desativar").attr("disabled", true);
        var carrega = document.getElementById('aguarde_desativar');
        carrega.style.display = 'block';

        var id_desativar = $("#id_desativar").val();
        var status_desativar = $("#status_desativar").val();

        jQuery.ajax({
            type: "POST",
            url: "processos/CXESCAD003CON/CXESCAD003DESAT.php",
            data: { id: id_desativar, status: status_desativar },
            success: function (data) {
                carrega.style.display = 'none';

                if (data == "ok") {
                    var ok = document.getElementById('sucesso_desativar');
                    ok.style.display = 'block';
                    setTimeout(function () {
                        ok.style.display = 'none';
                        $("#confirma_desativar").attr("disabled", false);
                        $("#ModalDesativar").modal("hide");
                        Filtrar();
                        return false;
                    }, 1500);
                    return false;
                }
                else {
                    $("#confirma_desativar").attr("disabled", false);
                    var erro = document.getElementById('erro_desativar');
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
    });
});