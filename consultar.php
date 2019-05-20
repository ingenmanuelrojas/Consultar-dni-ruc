<?php
	require 'simple_html_dom.php';
	error_reporting(E_ALL ^ E_NOTICE);

	$documento  = $_REQUEST['dni'];
	$tipo_doc   = $_REQUEST['tipo_doc'];

	if ($tipo_doc == "dni") {
		//OBTENEMOS EL VALOR
		$consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$documento)->plaintext;
		 
		//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
		 
		$partes = explode("|", $consulta);
		 
		$datos = array(
			0 => $dni,
			1 => $partes[0],
			2 => $partes[1],
			3 => $partes[2],
		);
		 
		echo json_encode($datos);

	}else if($tipo_doc == "ruc"){
		$data = file_get_contents("https://api.sunat.cloud/ruc/".$documento);
		$info = json_decode($data, true);

		if($data==='[]' || $info['fecha_inscripcion']==='--'){
			$datos = array(0 => 'nada');
			echo json_encode($datos);
		}else{
		$datos = array(
			0 => $info['ruc'], 
			1 => $info['razon_social'],
			2 => date("d/m/Y", strtotime($info['fecha_actividad'])),
			3 => $info['contribuyente_condicion'],
			4 => $info['contribuyente_tipo'],
			5 => $info['contribuyente_estado'],
			6 => date("d/m/Y", strtotime($info['fecha_inscripcion'])),
			7 => $info['domicilio_fiscal'],
			8 => date("d/m/Y", strtotime($info['emision_electronica']))
		);
			echo json_encode($datos);
		}
	}

?>