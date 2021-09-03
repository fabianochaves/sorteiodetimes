var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var mask = '00:00 - 00:00';
        $('.horarioPeriodo').mask(mask, op);
    }
}

$('.horarioPeriodo').mask('00:00 - 00:00', options);

$('.horarioPeriodo').focusin(function () {
    if ($(this).val() == '00:00 - 00:00') {
        $(this).val('');
    }
});

$('.horarioPeriodo').blur(function () {
    if (validarMaskPeriodo($(this).val()) == false) {
        $(this).val('00:00 - 00:00');
    }
});

function validarMaskHorario(valor) {
    var valorSplit = valor.split(':');

    if (valorSplit.length == 2) {
        var horas = valorSplit[0];
        var minutos = valorSplit[1];

        if ((minutos >= 0 && minutos < 60 && minutos.length == 2) && (horas >= 0 && horas < 24 && horas.length == 2)) {
            return true;
        }
    }

    return false;
}

function validarMaskPeriodo(valor) {
    var valorSplit = valor.split(' - ');

    if (valorSplit.length == 2) {
        var horario1 = valorSplit[0];
        var horario2 = valorSplit[1];

        if (validarMaskHorario(horario1) && validarMaskHorario(horario2)) {
            if (compararMaskPeriodo(horario1, horario2)) {
                return true;
            }
        }
    }

    return false;
}

function compararMaskPeriodo(valor1, valor2) {
    var valor1Split = valor1.split(':');
    var valor2Split = valor2.split(':');

    var horas1 = valor1Split[0];
    var minutos1 = valor1Split[1];

    var horas2 = valor2Split[0];
    var minutos2 = valor2Split[1];

    if (horas2 > horas1) {
        return true;
    } else if (horas2 == horas1 && minutos2 > minutos1) {
        return true;
    }

    return false;
}

///////////////////////////////////////////////////////

var optionsHorario = {
    onKeyPress: function (cpf, ev, el, op) {
        var mask = '00:00';
        $('.horario').mask(mask, op);
    }
}

$('.horario').blur(function () {
    let horario = $(this).val();
    if (validarMaskHorario(horario) == false) {
        $(this).val('00:00');
    }
});

$('.horario').mask('00:00', optionsHorario);

///////////////////////////////////////////////////////


var behaviorHorasTotais = function (val) {
    return val.replace(/\D/g, '').length <= 4 ? '00:000' : '000:00';
};
optionsHorasTotais = {
    onKeyPress: function (val, e, field, optionsHorasTotais) {
        field.mask(behaviorHorasTotais.apply({}, arguments), optionsHorasTotais);
    }
};

$('.horasTotais').mask(behaviorHorasTotais, optionsHorasTotais);

$('.horasTotais').blur(function () {
    var horario = $(this).val();
    if (horario != '') {
        var minutos = horario.split(':')[1];
        if (minutos >= 60 || minutos < 0) {
            $(this).val('');
        }
    }
});