$(function() {

//Plugin para Validar Formulario Validation Engine
	
    $("#<?php echo $this->campoSeguro('gestionRiesgo')?>").validationEngine({
        promptPosition : "topRight:100", 
        scroll: false,
        autoHidePrompt: true,
        autoHideDelay: 2000
         });


    $(function() {
        $("#<?php echo $this->campoSeguro('gestionRiesgo')?>").submit(function() {
            $resultado=$("#<?php echo $this->campoSeguro('gestionRiesgo')?>").validationEngine("validate");
             if ($resultado) {
                return true;
            }
            return false;
        });
    });
	
	
// Plugin para Pestañas
	$("#tabs").tabs();
	
// Plugin de Select2 Campos de Selección	
	$("#<?php echo $this->campoSeguro('region')?>").select2();
	$("#<?php echo $this->campoSeguro('sector')?>").select2();
	/*Buques Comerciales*/
	$("#<?php echo $this->campoSeguro('tiempo1BC')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2BC')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo3BC')?>").select2();
	/*BUques de Energía*/
	$("#<?php echo $this->campoSeguro('tiempo1BE')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2BE')?>").select2();
	
	
});
