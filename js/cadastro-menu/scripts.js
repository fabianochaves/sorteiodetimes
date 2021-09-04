$(document).ready(function() {

    $('.chosen-select').chosen('destroy').chosen();

    jQuery('#status').change(function(){
        if ($(this).val() == 0)
        {
            $(this).val('1');
        }
        else
        {
            $(this).val('0');
        }
    });

    jQuery('#tipo').change(function(){
        const valor = $(this).val();
        const divRotina = document.getElementById('div_rotina');
        const rotina = document.getElementById('rotina');

        if (valor != 0)
        {
            divRotina.style.display = 'block';
            rotina.required = true;
        }
        else
        {
            divRotina.style.display = 'none';
            rotina.required = false;
        }

        return false;
    });

    jQuery('#formulario').submit(function(){

        $("#btn_cadastrar").empty(); 
        $("#btn_cadastrar").append("<img src='assets/images/gif/aguarde1.gif' style='width:40px; height: 40px;' />"); 

        $("#btn_cadastrar").attr("disabled", true); 

        var dados = jQuery( this ).serialize();

        const rotina = document.getElementById('rotina');
        let obrigatorios = true;

        $('.obrigatorios').each(function(){            
            if ($(this).val() == ''){
                obrigatorios = false;
                return;
            }
         });

        if(!obrigatorios || (rotina.required && $('#rotina').val() == ''))
        {
            setTimeout(function() {

                $("#btn_cadastrar").empty(); 
                $("#btn_cadastrar").append("<i class='fa fa-check-circle'></i> Salvar"); 

                $("#btn_cadastrar").attr("disabled", false); 

                return false;

            }, 2000);

        }
        else
        {
            jQuery.ajax({
                type: "POST",
                url: "processos/cadastro-menu/cadastro-menu-gravar.php",
                data: dados,
                success: function( data )
                {  
                    setTimeout(function() {

                       $("#btn_cadastrar").empty(); 
                       $("#btn_cadastrar").append("<i class='fa fa-check-circle'></i> Salvar"); 

                       var exp = data.split('_');
                       var status = exp[0];
                       var mensagem = exp[1];

                       if (status == 'erro')
                       {

                        $("#btn_cadastrar").attr("disabled", false);

                        $('#msg_erro').empty();
                        $('#msg_erro').text(mensagem);

                        var erro = document.getElementById('erro');

                        erro.style.display = 'block';

                        setTimeout(function() {
                            erro.style.display = 'none'; 
                            return false;
                        }, 3000);


                        return false;
                        }
                        else if (status == 'ok')
                        {
                            $('#cod_gerado').empty();
                            $('#cod_gerado').text(mensagem);

                            var sucesso = document.getElementById('sucesso');

                            sucesso.style.display = 'block';

                            setTimeout(function() {
                                sucesso.style.display = 'none'; 
                                window.location.reload();
                                return false;
                            }, 2000);

                            return false;
                        }

                }, 2000);
            }
        });
            return false;
        }
    });
});
