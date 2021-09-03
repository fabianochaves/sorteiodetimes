$(document).ready(function () {
    setTimeout(() => {
        if ($("#moduloSelecionado").offset() != null) {
            $("#menuModulosSelect").stop().animate({
                scrollTop: $("#moduloSelecionado").offset().top - 200
            }, 25);
        }
    }, 200);
});

$(document).ready(function () {
    var empresaWidthInterval = false;
    var empresaChosenDestroyed = false;

    iniciarSetEmpresaWidthInterval();

    function setEmpresaWidthInverval() {
        var pesquisarWidth = $('#pesquisar').outerWidth();

        if (pesquisarWidth < 50 && empresaChosenDestroyed == false) {
            $('#empresaSelecionada').chosen('destroy');
            empresaChosenDestroyed = true;
        }

        if (pesquisarWidth >= 50 && empresaChosenDestroyed == true) {
            setTimeout(() => {
                $('#empresaSelecionada').chosen('destroy').chosen();
            }, 350);
            empresaChosenDestroyed = false;
        }
    }

    function iniciarSetEmpresaWidthInterval() {
        if (empresaWidthInterval === false) {
            setInterval(() => {
                setEmpresaWidthInverval();
            }, 50);
        }
    }

    $('#btnHambuger').click(function () {
        redrawElements();
    });

    $("#pesquisar").on("keyup", function () {

        $(".mm-active").not("#moduloSelecionado").removeClass('mm-active');

        if ($(this).val() == "") {
            $(".mm-collapse").attr("class", "mm-collapse");
        } else {
            $(".mm-collapse").attr("class", "mm-collapse mm-show");
        }

        var value = $(this).val().toLowerCase();
        $(".vertical-nav-menu li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#empresaSelecionada").change(function () {
        var empresaSelecionada = $(this).val();

        jQuery.ajax({
            type: "POST",
            url: "processos/menu/mudarEmpresa.php",
            data: { idEmpresa: empresaSelecionada },
            success: function (data) {
                return false;
            }
        });
    });
});

$(document).ready(function () {
    $('#btnMenuUsuario').click(function () {
        var idMenu = '#menuDropdownUsuario';
        var classeHide = 'dropdown-menu dropdown-menu-right';
        var classeShow = 'dropdown-menu dropdown-menu-right show';

        if ($(idMenu).prop('className') == classeShow)
            $(idMenu).prop('className', classeHide);
        else
            $(idMenu).prop('className', classeShow);
    });
});