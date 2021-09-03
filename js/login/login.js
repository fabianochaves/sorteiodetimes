jQuery(document).ready(function(){

	jQuery('#form-login').submit(function(){
	
		var dados = jQuery( this ).serialize();
		var gif = document.getElementById('aguarde_login');
		gif.style.display = 'block';

		$("#btn_entrar").attr("disabled", true);

		jQuery.ajax({
			type: "POST",
			url: "processos/login/verificaLogin.php",
			data: dados,
			success: function( data )
			{						
				gif.style.display = 'block';

				var status = data.split('_')[0];
				var msg = data.split('_')[1];

				if(status == "ok")
				{
					location.href= "inicio";
				}
				else
				{
					gif.style.display = 'none';
					var erro = document.getElementById('alert_erro');
					erro.style.display = 'block';
					$('#msg_erro').empty();
					$('#msg_erro').text(msg);

					setTimeout(function() {
						erro.style.display = 'none';

						$("#btn_entrar").attr("disabled", false); 								
					}, 3000);
				}
				return false;
			}
		});
		return false;
	});
	return false;
});