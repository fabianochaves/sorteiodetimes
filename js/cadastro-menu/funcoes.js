$(document).ready(function() {


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
});