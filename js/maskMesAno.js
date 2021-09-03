var maskMesAno = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['00/0000'];
        $('.mesAno').mask(masks[0], op);
    }
}

$('.mesAno').mask('00/0000#', maskMesAno);