<?php
	/*header("Content-Type: application/json");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");*/
	require_once 'include/DbHorarios.php';
	require_once 'include/DbPacientes.php';
	require_once 'include/DbEspecialidades.php';
	require_once 'include/DbDoctores.php';
	require_once 'include/DbCitas.php';
	require 'vendor/autoload.php';

	$app = new Slim\App();

	$app->get('/', function($request, $response, $args){
		$response->write("hola mundo slim");
		return $response;
	});

	$app->get('/hola[/{nombre}]',function($request, $response, $args){
		$response->write("Hola, " . $args["nombre"]);
		return $response;
	});

	$app->post('/pruebapost', function($request, $response, $args){
		$reqPost = $request->getParsedBody();
		$val = $reqPost["horario"];
		$response->write("Hola, " . $val);
		return $response;
	});

	    /*HORARIOS */
    $app->get('/gethorario', function($request, $response, $args){
        $dbh = new DbHorarios();
        $response = json_encode($dbh->seleccionarHorario());
        return $response;
    });

    $app->post('/inserthorario', function($request, $response, $args){
        $dbh = new DbHorarios();
        $response = $dbh-> ingresarHorario($request->getParsedBody());
        if ($response['operacion']) {
        	unset($response['operacion']);
        	$return = json_encode($dbh->horario($response));	
        }else{
        	$return = "Ocurrio un error";
        }
        return $return;
    });

    $app->post('/puthorario', function($request, $response, $args){
        $dbh = new DbHorarios();
        $response = $dbh-> actualizarHorario($request->getParsedBody());
        return $response;
    });

    $app->post('/deletehorario', function(){
        $dbh = new DbHorarios();
        $request_params = array();
        $request_params = $_REQUEST;
        $response = $dbh-> eliminarHorario($request_params);
        echoResponse(200,$response);
    });
    $app->post('/horario', function(){
        $dbh = new DbHorarios();
        $request_params = array();
        $request_params = $_REQUEST;
        $response = $dbh-> horario($request_params);
        echoResponse(200,$response);
    });
	$app->run();
?>