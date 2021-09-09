jQuery(document).ready(function () {

    jQuery('.gerar_imagem').click(function () {
        
        var id_sorteio = $(this).attr("id");

        html2canvas(document.getElementById('lista_times'), { allowTaint: true }).then(function (canvas) {
            
            var dataURL = canvas.toDataURL("image/png");

            var base64 = "data:image/png;base64,"+dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
         
            $(".download").attr("download", "Dados do Sorteio");
            $(".download").attr("href", base64);

            $(".gerar_imagem").remove();

            $(".download").append('<button class="btn btn-info baixar" type="button" id="'+id_sorteio+'">Download <i class="fa fa-download"></i></button>');
            
        });
    });
});