/* CXESCAD002FILTRO - MPS 30/11 - JS Consulta de Empresa */

function Filtrar() {

    $("#resultado_grid").empty();
    var carrega = document.getElementById('aguarde');

    carrega.style.display = 'block';

    var empresaID = $("#filtro_empresa").val().split('_')[0];
    var perfilID = $("#filtro_perfil").val();

    jQuery.ajax({
        type: "POST",
        url: "processos/CXESCAD003CON/CXESCAD003FILTRO.php",
        data: { ok: 1, empresaID: empresaID, perfilID: perfilID },
        success: function (data) {

            carrega.style.display = 'none';
            $("#resultado_grid").empty();
            $("#resultado_grid").html(data);

            $.fn.dataTable.moment('DD/MM/YYYY');
            $('#tab_grid').dataTable().fnDestroy();

            var empresa = $("#filtro_empresa").val().split('_')[1];

            var table = $('#tab_grid').DataTable({
                "scrollY": "340px",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                /*
                "fixedColumns":   {
                    leftColumns: 3
                },
                */
                "info": false,
                "order": [[1, "asc"]],
                "language": {
                    "lengthMenu": "Exibir _MENU_ registros por página",
                    "zeroRecords": "Nenhum Registro encontrado...",
                    "info": "Mostrando página _PAGE_ de _PAGES_ (filtrando de um total de _MAX_ registros)",
                    "infoEmpty": "Sem Registros do filtro",
                    //"infoFiltered": "(filtrando de um total de _MAX_ registros)",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    buttons: {
                        copyTitle: 'Tabela Copiada',
                        copySuccess: {
                            _: '%d registros copiados',
                            1: '%d registros copiados'
                        }
                    }
                },
                lengthChange: false,
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-files-o"></i>',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                        },
                        copyTitle: "Tabela Copiada"

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                        },
                        title: '<center><font size="4">Usuários - Empresa: ' + empresa + '</font></center>',
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                        },
                        title: 'Usuários - Empresa: ' + empresa,
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                        },
                        title: 'Usuários - Empresa: ' + empresa,
                        customize: function (doc) {
                            doc.pageMargins = [20, 15, 20, 15];

                            const colCount = doc.content[1].table.body[0].length;
                            const maxSize = 12;
                            const minSize = 6;

                            const getNewFontSize = (colCount) => {
                                let size = 22 - colCount;

                                size = size > maxSize ? maxSize : size;
                                size = size < minSize ? minSize : size;

                                return size;
                            }

                            if (doc.content[1].table.body[0] && colCount) {
                                let newFontSize = getNewFontSize(colCount);
                                doc.defaultStyle.fontSize = newFontSize;

                                doc.styles.tableHeader.fontSize =
                                    doc.styles.tableFooter.fontSize = newFontSize + 1;
                            }
                        },
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-th-list"></i>'
                    }
                ]
            });
            table.buttons().container().appendTo('#tab_grid_wrapper .col-md-6:eq(0)');
            return false;
        }
    });
    return false;


}

jQuery(document).ready(function () {
    $('.chosen-select').chosen('destroy').chosen();

    jQuery('#btn_filtro').click(function () {
        Filtrar();
    });

});

// #####################################################

(function (factory) {
    if (typeof define === "function" && define.amd) {
        define(["jquery", "moment", "datatables.net"], factory);
    } else {
        factory(jQuery, moment);
    }
}(function ($, moment) {

    $.fn.dataTable.moment = function (format, locale, reverseEmpties) {
        var types = $.fn.dataTable.ext.type;

        // Add type detection
        types.detect.unshift(function (d) {
            if (d) {
                // Strip HTML tags and newline characters if possible
                if (d.replace) {
                    d = d.replace(/(<.*?>)|(\r?\n|\r)/g, '');
                }

                // Strip out surrounding white space
                d = $.trim(d);
            }

            // Null and empty values are acceptable
            if (d === '' || d === null) {
                return 'moment-' + format;
            }

            return moment(d, format, locale, true).isValid() ?
                'moment-' + format :
                null;
        });

        // Add sorting method - use an integer for the sorting
        types.order['moment-' + format + '-pre'] = function (d) {
            if (d) {
                // Strip HTML tags and newline characters if possible
                if (d.replace) {
                    d = d.replace(/(<.*?>)|(\r?\n|\r)/g, '');
                }

                // Strip out surrounding white space
                d = $.trim(d);
            }

            return !moment(d, format, locale, true).isValid() ?
                (reverseEmpties ? -Infinity : Infinity) :
                parseInt(moment(d, format, locale, true).format('x'), 10);
        };
    };

}));


$(function () {
    $('.daterange').daterangepicker({

        locale: {
            format: 'DD/MM/YYYY',
            separator: ' - ',
            applyLabel: 'Aplicar',
            cancelLabel: 'Cancelar',
            fromLabel: 'De',
            toLabel: 'At&eatilde',
            customRangeLabel: 'Escolha',
            daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            firstDay: 1
        },

        opens: 'left'
    }, function (start, end, label) {
        console.log(start.format('DD/MM/YYYY') + ' até ' + end.format('DD/MM/YYYY'));
    }

    );
});


/* Função para um input mostrar um calendário "datepicker.js" */

$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    //startDate: '0d',
    endDate: '0d',
    language: 'pt-BR',
    autoclose: true
});