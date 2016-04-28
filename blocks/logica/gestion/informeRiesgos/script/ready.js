$(function() {

	// Plugin para Validar Formulario Validation Engine

	$("#<?php echo $this->campoSeguro('informeRiesgos')?>").validationEngine({
		promptPosition : "topRight:-10",
		scroll : false,
		autoHidePrompt : true,
		autoHideDelay : 9000
	});
	$("#<?php echo $this->campoSeguro('informeRiesgos')?>").submit(function() {
		$resultado = $("#<?php echo $this->campoSeguro('informeRiesgos')?>").validationEngine("validate");
		if ($resultado) {

			return true;
		}
		return false;
	});


	
	/* Consulta */
	$("#<?php echo $this->campoSeguro('region_consulta')?>").select2();
	$("#<?php echo $this->campoSeguro('sector_consulta')?>").select2();

	$("#<?php echo $this->campoSeguro('fecha_inicio_consulta')?>")
			.datepicker(
					{
						dateFormat : 'yy-mm-dd',
						maxDate : 0,
						changeYear : true,
						changeMonth : true,
						monthNames : [ 'Enero', 'Febrero', 'Marzo', 'Abril',
								'Mayo', 'Junio', 'Julio', 'Agosto',
								'Septiembre', 'Octubre', 'Noviembre',
								'Diciembre' ],
						monthNamesShort : [ 'Ene', 'Feb', 'Mar', 'Abr', 'May',
								'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
						dayNames : [ 'Domingo', 'Lunes', 'Martes', 'Miercoles',
								'Jueves', 'Viernes', 'Sabado' ],
						dayNamesShort : [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue',
								'Vie', 'Sab' ],
						dayNamesMin : [ 'Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi',
								'Sa' ],
						onSelect : function(dateText, inst) {
							var lockDate = new Date(
									$(
											"#<?php echo $this->campoSeguro('fecha_inicio_consulta')?>")
											.datepicker('getDate'));
							$(
									"input#<?php echo $this->campoSeguro('fecha_final_consulta')?>")
									.datepicker('option', 'minDate', lockDate);
						},
						onClose : function() {
							if ($(
									"input#<?php echo $this->campoSeguro('fecha_inicio_consulta')?>")
									.val() != '') {
								$(
										"#<?php echo $this->campoSeguro('fecha_final_consulta')?>")
										.attr("class",
												"cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
							} else {
								$(
										"#<?php echo $this->campoSeguro('fecha_final_consulta')?>")
										.attr("class",
												"cuadroTexto ui-widget ui-widget-content ui-corner-all ");
							}
						}

					});
	$("#<?php echo $this->campoSeguro('fecha_final_consulta')?>")
			.datepicker(
					{
						dateFormat : 'yy-mm-dd',
						maxDate : 0,
						changeYear : true,
						changeMonth : true,
						monthNames : [ 'Enero', 'Febrero', 'Marzo', 'Abril',
								'Mayo', 'Junio', 'Julio', 'Agosto',
								'Septiembre', 'Octubre', 'Noviembre',
								'Diciembre' ],
						monthNamesShort : [ 'Ene', 'Feb', 'Mar', 'Abr', 'May',
								'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
						dayNames : [ 'Domingo', 'Lunes', 'Martes', 'Miercoles',
								'Jueves', 'Viernes', 'Sabado' ],
						dayNamesShort : [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue',
								'Vie', 'Sab' ],
						dayNamesMin : [ 'Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi',
								'Sa' ],
						onSelect : function(dateText, inst) {
							var lockDate = new Date(
									$("#<?php echo $this->campoSeguro('fecha_final_consulta')?>").datepicker('getDate'));
							$("input#<?php echo $this->campoSeguro('fecha_inicio_consulta')?>").datepicker('option', 'maxDate', lockDate);
						},
						onClose : function() {
							if ($("input#<?php echo $this->campoSeguro('fecha_final_consulta')?>").val() != '') {
								$("#<?php echo $this->campoSeguro('fecha_inicio_consulta')?>").attr("class","cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
							} else {
								$("#<?php echo $this->campoSeguro('fecha_inicio_consulta')?>").attr("class","cuadroTexto ui-widget ui-widget-content ui-corner-all ");
							}
						}

					});
	
	
	
	//Recomendaciones
	
	$("#<?php echo $this->campoSeguro('riesgo')?>").select2();
	
	
	

});






