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
	$sql	= "SELECT * FROM Empresa";
	$query 	=mysqli_query($con,$sql);
	$data 	= array();
	while($fila = mysqli_fetch_assoc($query))
	{
		$data[] = $fila;
	}
	echo json_encode($data);
}

function ver($id){
	global $con;
	$sql	= "SELECT * FROM Empresa WHERE EmpresaId=".$id;
	$query 	= mysqli_query($con,$sql);
	$data 	= array();
	$fila 	= mysqli_fetch_assoc($query);
	echo json_encode($fila);
}

?>