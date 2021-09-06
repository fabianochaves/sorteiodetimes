jQuery(document).ready(function () {
    $('.chosen-select').chosen('destroy').chosen();

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        endDate: '0d',
        language: 'pt-BR',
        autoclose: true,
        todayHighlight: true
    });

    const masks = "https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js";

    $.getScript(masks, () => {
        $.getScript("js/cep.js", () => { });
        $.getScript("js/cpf.js", () => { });
        $.getScript("js/cpfcnpj.js", () => { });
        $.getScript("js/maskfone.js", () => { });
        $.getScript("js/maskdata.js", () => { });
        $.getScript("js/maskhorario.js", () => { });
        $.getScript("js/somenteNumeros.js", () => { });
        $.getScript("js/somenteLetras.js", () => { });
    });
});