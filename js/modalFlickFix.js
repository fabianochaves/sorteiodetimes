$(document).ready(function () {
    $('.modal').on('hidden.bs.modal', function () {
        $(this).hide();
    }).modal('hide');
});