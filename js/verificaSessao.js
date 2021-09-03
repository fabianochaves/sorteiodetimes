$(document).ready(function () {
    setInterval(() => {
        jQuery.ajax({
            type: "POST",
            url: "processos/login/verificaSessao.php",
            data: {},
            success: function (data) {
                let result = JSON.parse(data);
                if (result.ok == false)
                    location.reload();

                // console.log('Tempo Restante: ' + result.tempoRestante.toString() + ' segundos');
            }
        });
    }, 1000);
});