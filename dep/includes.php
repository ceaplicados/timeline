<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("../dep/clases/DaoSessions.php");
include_once("../dep/clases/DaoUsuarios.php");
include_once("../dep/clases/DaoCliente.php");

$DaoSessions= new DaoSessions();
$DaoUsuarios=new DaoUsuarios();
$DaoCliente=new DaoCliente();

$noSessionPages=array();
array_push($noSessionPages, "logout");
array_push($noSessionPages, "login");

$file_script=$_SERVER['SCRIPT_FILENAME'];
$file_script=substr($file_script,0, strpos($file_script,".php"));
while(strpos($file_script,"/")!== false){
	$file_script=substr($file_script, strpos($file_script,"/")+1);
}

$Session=new Sessions();
if(isset($_COOKIE["SessionUID"])){
	$Session=$DaoSessions->getSession($_COOKIE["SessionUID"]);
	if(!$Session->getId()>0){
		if(!in_array($file_script, $noSessionPages) && !$DaoSessions->_pruebas){
			header("Location: /login?reason=sessionNotFound");
			exit();
		}
	}
	$deathSession=strtotime($Session->getDateDeath());
	if($deathSession<time()){
		$Session=new Sesiones();
		if(!in_array($file_script, $noSessionPages) && !$DaoSessions->_pruebas){
			header("Location: /login?reason=sessionDeath");
			exit();
		}
	}
}

$Usuario=new Usuarios();
if($Session->getUsuario()>0){
	$Usuario=$DaoUsuarios->show($Session->getUsuario());
}

if(!$Session->getUsuario()>0){
	$Session=new Sessions();
	if(!in_array($file_script, $noSessionPages) && !$DaoSessions->_pruebas){
		header("Location: /login?reason=userNotFound");
		exit();
	}
}
$Cliente=new Cliente();
if($Session->getCliente()>0){
	$Cliente=$DaoCliente->show($Session->getCliente());
}
if(!$Cliente->getId()>0 && $file_script!=="choose_cliente"){
	if(!in_array($file_script, $noSessionPages) && !$DaoSessions->_pruebas){
		header("Location: /cambiar_org");
		exit();
	}
}
if($DaoSessions->_pruebas){
	$Cliente=$DaoCliente->show(1);
	$Usuario=$DaoUsuarios->show(1);
}