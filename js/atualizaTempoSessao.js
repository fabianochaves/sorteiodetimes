(function () {
    let waitToListenRequests = false;

    var origOpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function () {
        this.addEventListener('load', function () {
            if (waitToListenRequests == false &&
                !this.responseURL.toUpperCase().includes('VERIFICASESSAO')) {
                waitToListenRequests = true;

                setTimeout(() => {
                    waitToListenRequests = false;
                }, 2000);

                atualizarTempoSessao();
            }
        });
        origOpen.apply(this, arguments);
    };
})();

function atualizarTempoSessao() {
    jQuery.ajax({
        type: "POST",
        url: "processos/login/atualizaTempoSessao.php",
        data: {},
        success: function (data) {
            // let resposta = JSON.parse(data);
            // console.log('Atualizando tempo da sessão...');
        }
    });
}