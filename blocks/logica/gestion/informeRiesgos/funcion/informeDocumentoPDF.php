<?php
$ruta = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" );
include ($ruta . "/plugin/html2pdf/html2pdf.class.php");

class ProcesarInforme {
	var $miConfigurador;
	var $miInspectorHTML;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miInspectorHTML = \InspectorHTML::singleton ();
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function contenidoInforme() {
// 		var_dump ( $_REQUEST );
		/*
		 * Consultar Recomendaciones
		 */
		
		$conexion = "logica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( "consultar_recomedaciones", $_REQUEST ['id_zona'] );
		
		$recomendaciones = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
// 		var_dump ( $recomendaciones );
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );
// 		echo $directorio;
		// exit ();
		
		$contenidoPagina = "
				<style type=\"text/css\">
				    table {
				        color:#333; /* Lighten up font color */
				        font-family:Helvetica, Arial, sans-serif; /* Nicer font */
						
				        border-collapse:collapse; border-spacing: 3px;
				    }
				    td, th {
				        border: 1px solid #CCC;
				        height: 13px;
				    } /* Make cells a bit taller */
					col{
					width=50%;
						
					}
						
				    th {
				        background: #F3F3F3; /* Light grey background */
				        font-weight: bold; /* Make sure they're bold */
				        text-align: center;
				        font-size:10px
				    }
				    td {
				        background: #FAFAFA; /* Lighter grey background */
				        text-align: left;
				        font-size:10px
				    }
				</style>
		
		
<page backtop='5mm' backbottom='5mm' backleft='10mm' backright='10mm'>
		
        <table align='left' style='width:100%;' >
            <tr>
                <td align='center' style='width:40%;' >
                    <img src='" . $directorio . "/css/logo_informe/Logo_Dimar.png'  width='200' height='100'>
                </td>
                <td align='center' style='width:60%;' >
                    <font size='9px'><b>DIRECCIÓN GENERAL MARÍTIMA</b></font>
                    <br>
                    <font size='7px'><b>Autoridad Marítima Colombiana</b></font>		
                    <br>		
                    <font size='7px'><b>NIT: 30.027.904-1</b></font>
                     <br>
                    <font size='3px'>CARRERA 7 No. 40-53 PISO 7. TELEFONO 3239300 EXT. 2609 -2605</font>
                     <br>
                    <font size='5px'>www.udistrital.edu.co</font>
                     <br>
                    <font size='4px'>" . date ( "Y-m-d" ) . "</font>
                </td>
            </tr>
        </table>
                    		
                    		
    </page> ";
		
		echo $contenidoPagina;
		exit;
		
	}
}

$miProcesador = new ProcesarInforme ( $this->lenguaje, $this->sql );
$contenido = $miProcesador->contenidoInforme ();

ob_start ();

$objetoPDF = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8');
// HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8');
$objetoPDF->pdf->SetDisplayMode ( 'fullpage' );
$objetoPDF->writeHTML ( $contenido );
$objetoPDF->Output ( "Informe_Resultados:" . $_REQUEST ['titulo_proyecto'] . "_" . date ( 'Y-m-d' ) . ".pdf", "D" );

?>