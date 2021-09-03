
var options = {
	onKeyPress: function (cpf, ev, el, op) {
		var masks = ['000.000.000-00'];
		$('.cpf').mask(masks[0], op);
	}
}

$('.cpf').mask('000.000.000-00#', options);

$('.cpf').blur(function () {
	let validarDocumento = true;

	if (validarDocumento) {
		let valor = $(this).val();
		let valido = validaCPF(valor);

		if (!valido) {
			$(this).val('');

			let element = $(this)[0];

			element.style.backgroundColor = '#ffcccb';

			setTimeout(() => {
				element.style.backgroundColor = '#fff';
			}, 1000);
		}
	}
});

function validaCPF(strCPF) {
	strCPF = strCPF.replace(/[^\d]+/g, '');

	var Soma;
	var Resto;
	Soma = 0;
	if (strCPF == "00000000000") return false;

	for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
	Resto = (Soma * 10) % 11;

	if ((Resto == 10) || (Resto == 11)) Resto = 0;
	if (Resto != parseInt(strCPF.substring(9, 10))) return false;

	Soma = 0;
	for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
	Resto = (Soma * 10) % 11;

	if ((Resto == 10) || (Resto == 11)) Resto = 0;
	if (Resto != parseInt(strCPF.substring(10, 11))) return false;
	return true;
}