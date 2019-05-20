<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Consultar DNI</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class=" row">
			<center><h1>Consultar DNI / RUC</h1></center>
			<div class="col-md-2">
      			<label>Tipo Documento:</label>
				<select name="cmb_tipo_documento" id="cmb_tipo_documento" class="form-control" onchange="buscar_campos()">
					<option value="">Seleccione...</option>
					<option value="dni">DNI</option>
					<option value="ruc">RUC</option>
				</select>
			</div>
			<div class="col-md-4">
      			<label>Ingrese Numero de Documento:</label>
				<div class="input-group">
					<input type="text" class="form-control" id="txt_documento" name="txt_documento" placeholder="Documento de Identidad" onkeypress="return soloNumeros(event)" onkeyup = "if(event.keyCode == 13) buscar();">
					<div class="input-group-addon btn" style="color: #fff; background-color: #b80009; " onclick="buscar();">Buscar</div>
			    </div>
			</div>
			<form method="post" accept-charset="utf-8" id="frm_consulta">
				<div id="capa_load"></div>
				<div class="col-md-12"><br></div>
				<div id="capa_datos_dni" style="display: none;">
				    <div class="form-group col-md-6">
					    <label>Nombre Completo:</label>
				      	<input type="text" name="txt_nombre" id="txt_nombre" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-3">
					    <label>Apellido Materno:</label>
				      	<input type="text" name="txt_apellido1" id="txt_apellido1" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-3">
					    <label>Apellido Paterno:</label>
				      	<input type="text" name="txt_apellido2" id="txt_apellido2" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="col-md-12">
				  		<div class="alert alert-warning" role="alert">
				  			Probar con el DNI: <b>47307518</b>
				  		</div>
				  	</div>
				</div>
				<div id="capa_datos_ruc" style="display: none;">
					<div class="form-group col-md-6">
					    <label>Razon Social:</label>
				      	<input type="text" name="txt_razon_social" id="txt_razon_social" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-3">
					    <label>Inicio de Actividad:</label>
				      	<input type="text" name="txt_inicio_actividad" id="txt_inicio_actividad" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-3">
					    <label>Condición:</label>
				      	<input type="text" name="txt_condicion" id="txt_condicion" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-4">
					    <label>Tipo de Contribuyente:</label>
				      	<input type="text" name="txt_tipo_contribuyente" id="txt_tipo_contribuyente" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-4">
					    <label>Estado de Contribuyente:</label>
				      	<input type="text" name="txt_estado_contribuyente" id="txt_estado_contribuyente" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-4">
					    <label>Fecha de Inscripción:</label>
				      	<input type="text" name="txt_fecha_inscripcion" id="txt_fecha_inscripcion" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-8">
					    <label>Domicilio:</label>
				      	<input type="text" name="txt_domicilio" id="txt_domicilio" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="form-group col-md-4">
					    <label>Emisión Electrónica:</label>
				      	<input type="text" name="txt_emision_electronica" id="txt_emision_electronica" value="" class="form-control" readonly="true">
				  	</div>
				  	<div class="col-md-12">
				  		<div class="alert alert-warning" role="alert">
				  			Probar con el RUC: <b>20522199819</b>
				  		</div>
				  	</div>
				</div>
			</form>
		</div>
	</div>

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function buscar_campos() {
			$('#capa_load').html('<img src="img/loading.gif" alt="" style="position: absolute;top: 10px;left: 46%;">');
			if ($('#cmb_tipo_documento').val() == "dni") {
				$('#capa_datos_dni').css('display', 'block');
				$('#capa_datos_ruc').css('display', 'none');
				$('#txt_documento').val("");
				$('#capa_load').html("");
				$("#frm_consulta")[0].reset();
			}else if($('#cmb_tipo_documento').val() == "ruc"){
				$('#capa_datos_ruc').css('display', 'block');
				$('#capa_datos_dni').css('display', 'none');
				$('#capa_load').html("");
				$('#txt_documento').val("");
				$("#frm_consulta")[0].reset();
			}
		}

		function buscar() {
			tipo_doc = $('#cmb_tipo_documento').val();
			if (tipo_doc == "") {
				alert("Debes seleccionar un tipo de documento.");
			}else{
				$('#capa_load').html('<img src="img/loading.gif" alt="" style="position: absolute;top: 10px;left: 46%;">');
				$.post('consultar.php', {dni: $('#txt_documento').val(),tipo_doc: tipo_doc}, function(data) {

					if (tipo_doc=="dni") {
						var datos = eval(data);
						if (datos == ",,,") {
							alert("No existe este DNI.");
							$('#capa_load').html("");
							$("#frm_consulta")[0].reset();
						}else{
							$('#txt_dni').val(datos[0]);
							$('#txt_nombre').val(datos[3]);
							$('#txt_apellido1').val(datos[1]);
							$('#txt_apellido2').val(datos[2]);
							$('#capa_load').html("");
						}
					}else{
						var datos = eval(data);
						var nada ='nada';
						if(datos[0]==nada){
							alert('RUC no válido o no registrado');
							$('#capa_load').html("");
							$("#frm_consulta")[0].reset();
						}else{
							$('#txt_razon_social').val(datos[1]);
							$('#txt_inicio_actividad').val(datos[2]);
							$('#txt_condicion').val(datos[3]);
							$('#txt_tipo_contribuyente').val(datos[4]);
							$('#txt_estado_contribuyente').val(datos[5]);
							$('#txt_fecha_inscripcion').val(datos[6]);
							$('#txt_domicilio').val(datos[7]);
							$('#txt_emision_electronica').val(datos[8]);
						}	
						$('#capa_load').html("");
					}

				});
			}
		}

		function soloNumeros(e){
		    var key = window.event ? e.which : e.keyCode;
		    if (key < 48 || key > 57) {
		        //Usando la definición del DOM level 2, "return" NO funciona.
		        e.preventDefault();
		    }
		}


	</script>
</body>
</html>