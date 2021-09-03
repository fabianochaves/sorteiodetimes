$(document).ready(function () {

    /* Função para campo aceitar somente letras */
    jQuery('.somenteLetras').keyup(function () {
        this.value = this.value.replace(/[^a-zA-Zá àâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ.]/g, '');
    });

    jQuery('.somenteTextoSemCaracteresEspeciais').keyup(function () {
        this.value = this.value.replace(/[^a-zA-Z0-9 .]/g, '');
    });
});