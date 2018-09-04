<script type="text/javascript">
	$('.telefone').mask('(00) 0000-00009');
	$('.telefone').blur(function(event) {
		if($(this).val().length < 14){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
			$('.telefone').val('');
		}
	});

	function validacaoEmail(field) {
		usuario = field.val().substring(0, field.val().indexOf("@"));
		dominio = field.val().substring(field.val().indexOf("@")+ 1, field.val().length);
		if (
			(usuario.length >=1) &&
			(dominio.length >=3) && 
			(usuario.search("@")==-1) && 
			(dominio.search("@")==-1) &&
			(usuario.search(" ")==-1) && 
			(dominio.search(" ")==-1) &&
			(dominio.search(".")!=-1) &&      
			(dominio.indexOf(".") >=1)&& 
			(dominio.lastIndexOf(".") < dominio.length - 1)
		) {
			return true;
		} else {
			alert("E-mail inválido");
			return false;
		}
	}

	$(document).on('focusout', '.email', function(){
		var email = $(this);
		if (email.val() != "") {
			if(!validacaoEmail(email)){
				email.val('');
			}
		}
	});
	
	$(document).on('click', '.btn-primary', function(e){
		e.preventDefault();
		if ( $(this).parents('.flip-container').hasClass('flip-container-hover') ) {
			$(this).parents('.flip-container').removeClass('flip-container-hover');
		} else {
			$(this).parents('.flip-container').addClass('flip-container-hover');
		}
	});

	$(document).on('click', '.btn-success', function(e){
		e.preventDefault();
		var input = $(this).parents('.card');

		if (input.find('input[name="matricula-nome"]').val() == '') {
			alert('Por favor preencha o seu nome completo.');
			input.find('input[name="matricula-nome"]').focus();
			return false;
		} else if (input.find('input[name="matricula-email"]').val() == '') {
			alert('Por favor preencha o seu email.');
			input.find('input[name="matricula-email"]').focus();
			return false;
		} else if (input.find('input[name="matricula-telefone"]').val() == '') {
			alert('Por favor preencha o seu telefone.');
			input.find('input[name="matricula-telefone"]').focus();
			return false;
		} else {
			$('body').addClass('body-grey-loader');
			$('.loader').removeClass('hidden');

			input.find('form').submit();
			alert('Uma solicitação de contato será enviada, por favor aguarde que em instantes receberá um email com a confirmação.');
		}
	});	
</script>