/* JS Consulta de Sorteio */

function Filtrar() {

    $("#resultado_grid").empty();

    $("#aguarde").attr("style", "display: block; width: 120px; height: 120px;");

    var dados = $("#form_filtro").serialize();

    jQuery.ajax({
        type: "POST",
        url: "processos/consulta-sorteio/consulta-sorteio-filtro.php",
        data: dados,
        success: function (data) {

            $("#aguarde").attr("style", "display: none");
            $("#resultado_grid").empty();
            $("#resultado_grid").html(data);

            $.fn.dataTable.moment('DD/MM/YYYY');
            $('#tab_grid').dataTable().fnDestroy();

            var colunas = "1, 2";

            var table = $('#tab_grid').DataTable({
                "scrollY": "340px",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                
                "fixedColumns":   {
                    leftColumns: 1
                },
                
                
                "info": false,
                "order": [[2, "asc"]],
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
                            columns: [colunas]
                        },
                        copyTitle: "Tabela Copiada"

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        footer: true,
                        exportOptions: {
                            columns: [colunas]
                        },
                        title: '<center><font size="4">Usuários</font></center>',
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        footer: true,
                        exportOptions: {
                            columns: [colunas]
                        },
                        title: 'Usuários',
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        footer: true,
                        exportOptions: {
                            columns: [colunas]
                        },
                        title: 'Usuários',
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

    jQuery('#btn_filtro').click(function () {

        if($("#filtro").val() == ""){
            return false;
        }
        else{
            Filtrar();
        }
        
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