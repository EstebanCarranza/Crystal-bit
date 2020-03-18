<?php
	error_reporting(0);
	class msgResponse
	{
		public $msg = '';
		public $code = '';
		public $data = array();

		function __construct(){
			
		}
	}
	$action = $_POST['action'];

    switch($action)
    {
        case "agregarPartida":
            agregarPartida();
        break;
        case "obtenerPartida":
            obtenerPartida();
        break;
        case "obtenerPuntuaciones":
            obtenerPuntuaciones();
        break;
    }
	
	function connect() {
		
		$databasehost = "localhost";
		$databasename = "db_esteban";
		$databaseuser = "db_esteban";
		$databasepass = "db_esteban";
		try{
			$mysqli = new mysqli($databasehost, $databaseuser, $databasepass, $databasename);
			
		} catch (mysqli_sql_exception $e) {
			$return = new msgResponse();
			$return->msg = 'No hubo conexion con la base de datos';
			$return->code = '500';
			echo $return;
			throw $return;
		}
	}

	function disconnect() {
		mysqli_close();
	}

	function agregarPartida() {
		$mysqli = connect();
		if($mysqli != null){	
			$gamename_01 = $_POST["gamename_01"];
			$gamename_02 = $_POST["gamename_02"];
			$gamepoints_01 = $_POST["gamepoints_01"];
			$gamepoints_02 = $_POST["gamepoints_02"];

			$result = $mysqli->query("call sp_registrarPartida('$gamename_01', $gamepoints_01, '$gamename_02', $gamepoints_02);");
			
			if (!$result) {
				echo "Problema al hacer un query: " . $mysqli->error;								
			} else {
				// Recorremos los resultados devueltos
				$rows = array();
				while( $r = $result->fetch_assoc()) {
					$rows[] = $r;
				}			
				//Generar la respuesta
				$return = new msgResponse();
				$return->msg = 'Datos encontrados';
				$return->code = '200';
				array_push($return->data, $rows);
				
				//Regresar la respuesta en formato JSON
				echo json_encode($return);
				
			}
			mysqli_close($mysqli);
		}else{
			//No se pudo establecer conexion
			$return = new msgResponse();
			$return->msg = 'La consulta no pudo ser generada porque la base de datos no fue encontrada';
			$return->code = '500';
			echo json_encode($return);
		}
	}

	function obtenerPartida() {
		
		$mysqli = connect();
		if($mysqli != null){
			$idPartida = $_POST['idPartida'];
			$result = $mysqli->query("call sp_PuntuacionesPorPartida($idPartida);");	
			
			if (!$result) {
				echo "Problema al hacer un query: " . $mysqli->error;								
			} else {
				// Recorremos los resultados devueltos
				$rows = array();
				while( $r = $result->fetch_assoc()) {
					$rows[] = $r;
				}			
				//Generar la respuesta
				$return = new msgResponse();
				$return->msg = 'Datos encontrados';
				$return->code = '200';
				array_push($return->data, $rows);
				
				//Regresar la respuesta en formato JSON
				echo json_encode($return);
			}
			mysqli_close($mysqli);
		}else{
			//No se pudo establecer conexion
			$return = new msgResponse();
			$return->msg = 'La consulta no pudo ser generada porque la base de datos no fue encontrada';
			$return->code = '500';
			echo json_encode($return);
		}
    }
    function obtenerPuntuaciones()
    {
		
		$mysqli = connect();
		
		if($mysqli != null){
			
			$limit1 = $_POST['limit1'];
			$limit2 = $_POST['limit2'];
			$idTab = $_POST['idTab'];
			$result = $mysqli->query("call sp_Puntuaciones($limit1, $limit2,'$idTab');");	
			
			if (!$result) {
				echo "Problema al hacer un query: " . $mysqli->error;								
			} else {
				// Recorremos los resultados devueltos
				$rows = array();
				while( $r = $result->fetch_assoc()) {
					$rows[] = $r;
				}			
				//Generar la respuesta
				$return = new msgResponse();
				$return->msg = 'Datos encontrados';
				$return->code = '200';
				array_push($return->data, $rows);
				
				//Regresar la respuesta en formato JSON
				echo json_encode($return);
			}
			mysqli_close($mysqli);		
		}else{
			//No se pudo establecer conexion
			$return = new msgResponse();
			$return->msg = 'La consulta no pudo ser generada porque la base de datos no fue encontrada';
			$return->code = '500';
			echo json_encode($return);
		}
    }
?>