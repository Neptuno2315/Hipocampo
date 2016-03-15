$(function() {

	// Plugin para Validar Formulario Validation Engine

	$("#<?php echo $this->campoSeguro('zonaEstudio')?>").validationEngine({
		promptPosition : "topRight:-10",
		scroll : false,
		autoHidePrompt : true,
		autoHideDelay : 9000
	});

	// Plugin para Pestañas
	$("#tabs").tabs();


	$("#Libreria1").accordion({
		heightStyle:"content",
		collapsible: true,
		disabled: false
		
	});
	
	
	// Plugin de Select2 Campos de Selección
	$("#<?php echo $this->campoSeguro('region')?>").select2();
	$("#<?php echo $this->campoSeguro('sector')?>").select2();
	/* Buques Comerciales */
	$("#<?php echo $this->campoSeguro('tiempo1BC')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2BC')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo3BC')?>").select2();
	/* Buques de Energía */
	$("#<?php echo $this->campoSeguro('tiempo1BE')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2BE')?>").select2();
	/* Buques Pasajeros */
	$("#<?php echo $this->campoSeguro('tiempo1BP')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2BP')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo3BP')?>").select2();
	/* Buques Guerra */
	$("#<?php echo $this->campoSeguro('tiempo1BG')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2BG')?>").select2();
	/* Buques Pesqueros */
	$("#<?php echo $this->campoSeguro('tiempo1BPQ')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2BPQ')?>").select2();
	/* Servicios Marítimos */
	$("#<?php echo $this->campoSeguro('tiempo1SM')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2SM')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo3SM')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo4SM')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo5SM')?>").select2();

	/* Acua-Avíones Privados */
	$("#<?php echo $this->campoSeguro('tiempo1AA')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo2AA')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo3AA')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo4AA')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo5AA')?>").select2();

	/* Maxímo de Buques */
	$("#<?php echo $this->campoSeguro('tiempo_bq_gr')?>").select2();
	$("#<?php echo $this->campoSeguro('tiempo_bq_pq')?>").select2();

	/* Condiciones de Navegación */
	$("#<?php echo $this->campoSeguro('opera_nc_di')?>").select2();
	$("#<?php echo $this->campoSeguro('estado_mar')?>").width(650);
	$("#<?php echo $this->campoSeguro('estado_mar')?>").select2();
	$("#<?php echo $this->campoSeguro('con_hielo')?>").select2();
	$("#<?php echo $this->campoSeguro('ilum_fondo')?>").select2();

	/* Predicción Máxima Viento y Tormentas */
	$("#<?php echo $this->campoSeguro('pr_maxima')?>").width(650);
	$("#<?php echo $this->campoSeguro('pr_maxima')?>").select2();

	/* Predicción Efecto Combinado */
	$("#<?php echo $this->campoSeguro('pr_maxima_dgl')?>").width(650);
	$("#<?php echo $this->campoSeguro('pr_maxima_dgl')?>").select2();

	/* Factor Humano Calidad */
	$("#<?php echo $this->campoSeguro('pr_aton')?>").select2();
	$("#<?php echo $this->campoSeguro('pl_tr_mr')?>").select2();
	$("#<?php echo $this->campoSeguro('gr_cmp_trp')?>").select2();
	$("#<?php echo $this->campoSeguro('pq_cmp_trp')?>").select2();

});

$("#ventanaA").steps(
		{
			headerTag : "h4",
			bodyTag : "section",
			enableAllSteps : true,
			enablePagination : true,
			transitionEffect : "slideLeft",
			onStepChanging : function(event, currentIndex, newIndex) {
				$resultado = $("#<?php echo $this->campoSeguro('zonaEstudio')?>").validationEngine("validate");

				if ($resultado) {

					return true;
				}
				return false;
			},
			onFinished : function(event, currentIndex) {
				$("#<?php echo $this->campoSeguro('zonaEstudio')?>").submit();
			},
			labels : {
				cancel : "Cancelar",
				current : "Paso Siguiente :",
				pagination : "Paginación",
				finish : "Guardar Información",
				next : "Siquiente",
				previous : "Atras",
				loading : "Cargando ..."
			}

		});
