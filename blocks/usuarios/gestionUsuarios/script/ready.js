$(function() {
	// Plugin para Validar Formulario Validation Engine


	$("#<?php echo $this->campoSeguro('contrasenia')?>").attr('disabled','');	


	$("#<?php echo $this->campoSeguro('gestionUsuarios')?>").validationEngine({
		promptPosition : "topRight:-10",
		scroll : false,
		autoHidePrompt : true,
		autoHideDelay : 9000
	});


	$("#<?php echo $this->campoSeguro('gestionUsuarios')?>").submit(function() {
		$resultado = $("#<?php echo $this->campoSeguro('gestionUsuarios')?>").validationEngine("validate");
		if ($resultado) {

			return true;
		}
		return false;
	});



	// Plugin para Pestañas
	$("#tabs").tabs();


//Select2 (Formulario Usuario)
	$("#<?php echo $this->campoSeguro('tipo_ident')?>").width(260);
	$("#<?php echo $this->campoSeguro('tipo_ident')?>").select2();
	$("#<?php echo $this->campoSeguro('actualizar_password')?>").width(60);
	$("#<?php echo $this->campoSeguro('actualizar_password')?>").select2();	




 	$("#<?php echo $this->campoSeguro('actualizar_password')?>").change(function(){
	    		
	    		if($("#<?php echo $this->campoSeguro('actualizar_password')?>").val()==1){
	    			
	    				$("#<?php echo $this->campoSeguro('contrasenia')?>").removeAttr('disabled');

	    		}else if($("#<?php echo $this->campoSeguro('actualizar_password')?>").val()==0){


	    				$("#<?php echo $this->campoSeguro('contrasenia')?>").attr('disabled','');	
		            }

	});


	setTimeout(function() {
		$('#MensajeRespuesta').hide("drop", {
			direction : "up"
		}, "slow");
	}, 2000);


});



var $sigdiv2 =$("#firma_digital").jSignature();


$('#limpiarBn').bind('click', function(e){
		$sigdiv2.jSignature('reset');

		$("#<?php echo $this->campoSeguro('firmaUsuario');?>").val('');
		$("#firma_digital").css("display","block");
		$("#mensaje_firma_bn").css("display","none");
		$("#guardarBn").css("display","block");
	});



$('#guardarBn').bind('click', function(e){

 $("#<?php echo $this->campoSeguro('firmaUsuario');?>").val(btoa($sigdiv2.jSignature("getData", "svg")));

$("#firma_digital").css("display","none");
$("#mensaje_firma_bn").css("display","block");
$("#guardarBn").css("display","none");

	});