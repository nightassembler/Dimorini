<?php 

include("../config.php");
$headers=getallheaders();
$con=mysqli_connect($hostDB,$usuarioDB,$contrasenaDB) or die(mysqli_error($con));
mysqli_select_db($con,$nombreDB)or die(mysqli_error($con));
header('Content-Type: application/json');
if(!isset($_GET['uno'])&& $_SERVER['REQUEST_METHOD']=="GET"){
	listar();
}else{
	if(!isset($_GET['uno'])&& $_SERVER['REQUEST_METHOD']=="POST"){
		crear();
	}else{
		if(isset($_GET['uno']) && $_SERVER['REQUEST_METHOD']=="GET"){
			ver($_GET['uno']);
		}else{
			if(isset($_GET['uno']) && $_SERVER['REQUEST_METHOD']=="DELETE"){
				borrar($_GET['uno']);
			}else{
				if(isset($_GET['uno']) && $_SERVER['REQUEST_METHOD']=="PUT"){
					modificar($_GET['uno']);
				}
			}
		}
	}
}

function listar(){
	global $con;
	$sql	= "SELECT * FROM Usuario";
	$query 	= mysqli_query($con,$sql);
	$data 	= array();
	while($fila = mysqli_fetch_assoc($query)){
		$data[] = $fila;
	}
	echo json_encode($data);
}

function ver($id){
	global $con;
	$sql	= "SELECT * FROM Usuario WHERE UsuarioId=".$id;
	$query 	= mysqli_query($con,$sql);
	$data 	= array();
	$fila 	= mysqli_fetch_assoc($query);
	echo json_encode($fila);
}

function crear(){
	global $con;
	$request_body 	= file_get_contents('php://input');
	$data 			= json_decode($request_body);
	$sql = "INSERT INTO Usuario (UsuarioNombreUsu,UsuarioNombre,UsuarioApellido,UsuarioContrasena,UsuarioEsAdmin)
			VALUES ('".$data->data->NombreUsu."','".$data->data->Nombre."','".$data->data->Apellido."','".$data->data->Contrasena."',".$data->data->EsAdmin.")";
	mysqli_query($con,$sql) or die(mysqli_error($con));
}

function modificar($id){
	$request_body = file_get_contents('php://input');
	$data = json_decode($request_body);
	global $con;
	$sql="UPDATE Usuario SET
		UsuarioNombreUsu='".$data->NombreUsu."',
		UsuarioNombre='".$data->Nombre."',
		UsuarioApellido='".$data->Apellido."',
		UsuarioContrasena='".$data->Contrasena."',
		UsuarioEsAdmin='".$data->EsAdmin."'
		WHERE UsuarioId=".$id;
	$query = mysqli_query($con,$sql)or die(mysqli_error($con));
}

function borrar($id){
	global $con;
	$sql	= "DELETE FROM Usuario WHERE UsuarioId=".$id;
	$query 	= mysqli_query($con,$sql);
}

?>