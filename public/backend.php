<?php
require_once("../dep/interface.php");
$resp=array();
if(strpos($_SERVER["HTTP_REFERER"], $DaoSessions->getParam("dominio"))!==false){
	if($_POST["action"]=="checarSesion"){
		if(!in_array($file_script, $noSessionPages)){
			if($Session->getId()>0){
				$resp["result"]=true;
				if(strtotime($Session->getDateDeath()<=time())){
					$resp["result"]=false;
				}
			}else{
				$resp["result"]=false;
			}
		}else{
			$resp["result"]=true;
		}
		if($DaoSessions->_pruebas){
			$resp["result"]=true;
		}
		echo(json_encode($resp));	
	}
	
	if($_POST['action']=="cerrarSesiones"){
		$dateDeath=strtotime("- 2 minutes");
		foreach($DaoSessions->getByUsuarioId($Usuario->getId()) as $SessionAbierta){
			$SessionAbierta->setDateDeath(date("Y-m-d H:s:i",$dateDeath));
			$DaoSessions->update($SessionAbierta);
		}
		setcookie("SessionUID", "", time() - (86400 * 2), "/");
		$resp["result"]=true;
		echo(json_encode($resp));
	}
	if($_POST['action']=="cerrarSesion"){
		$SessionAbierta=$DaoSessions->show($_POST['Id']);
		$dateDeath=strtotime("- 2 minutes");
		$SessionAbierta->setDateDeath(date("Y-m-d H:s:i",$dateDeath));
		$DaoSessions->update($SessionAbierta);
		$resp["result"]=true;
		echo(json_encode($resp));
	}
	
	if($_POST['action']=="createTimeline"){
		require_once("../dep/clases/DaoTimelines.php");
		$DaoTimelines=new DaoTimelines();
		$Timelines=new Timelines();
		
		$Timelines->setNombre($_POST['Nombre']);
		$Timelines->setDescripcion($_POST['Descripcion']);
		$Timelines->setCliente($Cliente->getId());
		$Timelines->setDateBorn(date("Y-m-d H:i:s"));
		$Timelines->setCreatedBy($Usuario->getId());
		$Timelines=$DaoTimelines->add($Timelines);
		echo(json_encode($Timelines));
	}
	
	if($_POST['action']=="getFullTimeline"){
		require_once("../dep/clases/DaoSucesos.php");
		require_once("../dep/clases/DaoTimelines.php");
		require_once("../dep/clases/DaoLigas.php");
		require_once("../dep/clases/DaoNotas.php");
		require_once("../dep/clases/DaoArchivos.php");
		$DaoSucesos=new DaoSucesos();
		$DaoTimelines=new DaoTimelines();
		$DaoLigas=new DaoLigas();
		$DaoNotas=new DaoNotas();
		$DaoArchivos=new DaoArchivos();
		$timeline=$DaoTimelines->getByNonce($_POST["Timeline"]);
		$timeline->setfechaMin($DaoTimelines->getFechaMin($timeline->getId()));
		$timeline->setfechaMax($DaoTimelines->getFechaMax($timeline->getId()));
		$sucesos=$DaoSucesos->getByTimeline($timeline->getId());
		$i=0;
		while($i<count($sucesos)){
			$sucesos[$i]->setLigas($DaoLigas->getBySuceso($sucesos[$i]->getId()));
			$sucesos[$i]->setNotas($DaoNotas->getBySuceso($sucesos[$i]->getId()));
			$sucesos[$i]->setArchivos($DaoArchivos->getBySuceso($sucesos[$i]->getId()));
			$i=$i+1;
		};
		$timeline->setSucesos($sucesos);
		echo(json_encode($timeline));
	}
	
	if($_POST["action"]=="guardarSuceso"){
		require_once("../dep/clases/DaoSucesos.php");
		require_once("../dep/clases/DaoTimelines.php");
		$DaoSucesos=new DaoSucesos();
		$DaoTimelines=new DaoTimelines();

		$Sucesos=new Sucesos();
		
		if($_POST["Id"]>0){
			$Sucesos=$DaoSucesos->show($_POST["Id"]);
		}else{
			$timeline=$DaoTimelines->getByNonce($_POST["Timeline"]);
			$Sucesos->setTimeline($timeline->getId());
		}
		
		$Sucesos->setNombre($_POST['Nombre']);
		$Sucesos->setDescripcion($_POST['Descripcion']);
		$nivelDetalleFechaIni="anio";
		$FechaIni=$_POST['AnioFechaIni']."-01-01";
		if($_POST['MesFechaIni']!=="00"){
			$nivelDetalleFechaIni="mes";
			$FechaIni=$_POST['AnioFechaIni']."-".$_POST['MesFechaIni']."-01";
			if($_POST['DiaFechaIni']>0){
				$nivelDetalleFechaIni="dia";
				$FechaIni=$_POST['AnioFechaIni']."-".$_POST['MesFechaIni']."-".$_POST['DiaFechaIni'];
			}
		}
		$Sucesos->setFechaIni($FechaIni);
		$Sucesos->setNivelDetalleFechaIni($nivelDetalleFechaIni);
		
		$Sucesos->setFechaIni2(NULL);
		$Sucesos->setNivelDetalleFechaIni2(NULL);
		if($_POST['RangoFechaIni']==1){
			$nivelDetalleFechaIni="anio";
			$FechaIni=$_POST['AnioFechaIni1']."-01-01";
			if($_POST['MesFechaIni1']!=="00"){
				$nivelDetalleFechaIni="mes";
				$FechaIni=$_POST['AnioFechaIni1']."-".$_POST['MesFechaIni1']."-01";
				if($_POST['DiaFechaIni1']>0){
					$nivelDetalleFechaIni="dia";
					$FechaIni=$_POST['AnioFechaIni1']."-".$_POST['MesFechaIni1']."-".$_POST['DiaFechaIni1'];
				}
			}
			$Sucesos->setFechaIni2($FechaIni);
			$Sucesos->setNivelDetalleFechaIni2($nivelDetalleFechaIni);
		}
		
		$nivelDetalleFechaIni="anio";
		$FechaIni=$_POST['AnioFechaFin']."-01-01";
		if($_POST['MesFechaFin']!=="00"){
			$nivelDetalleFechaIni="mes";
			$FechaIni=$_POST['AnioFechaFin']."-".$_POST['MesFechaFin']."-01";
			if($_POST['DiaFechaFin']>0){
				$nivelDetalleFechaIni="dia";
				$FechaIni=$_POST['AnioFechaFin']."-".$_POST['MesFechaFin']."-".$_POST['DiaFechaFin'];
			}
		}
		$Sucesos->setFechaFin($FechaIni);
		$Sucesos->setNivelDetalleFechaFin($nivelDetalleFechaIni);
		
		$Sucesos->setFechaFin2(NULL);
		$Sucesos->setNivelDetalleFechaFin2(NULL);
		if($_POST['RangoFechaFin']==1){
			$nivelDetalleFechaIni="anio";
			$FechaIni=$_POST['AnioFechaFin1']."-01-01";
			if($_POST['MesFechaFin1']!=="00"){
				$nivelDetalleFechaIni="mes";
				$FechaIni=$_POST['AnioFechaFin1']."-".$_POST['MesFechaFin1']."-01";
				if($_POST['DiaFechaFin1']>0){
					$nivelDetalleFechaIni="dia";
					$FechaIni=$_POST['AnioFechaFin1']."-".$_POST['MesFechaFin1']."-".$_POST['DiaFechaFin1'];
				}
			}
			
			$Sucesos->setFechaFin2($FechaIni);
			$Sucesos->setNivelDetalleFechaFin2($nivelDetalleFechaIni);
		}
		$Sucesos=$DaoSucesos->addOrUpdate($Sucesos);
		echo(json_encode($Sucesos));
	}
	if($_POST['action']=="extraerLiga"){
		$resp=array();
		$resp["url"]=$_POST['URL'];
		libxml_use_internal_errors(true);
		$doc = new DomDocument();
		$doc->loadHTML(file_get_contents($_POST['URL']));
		$xpath = new DOMXPath($doc);
		$query = '//*/meta[starts-with(@property, \'og:\')]';
		$metas = $xpath->query($query);
		foreach ($metas as $meta) {
			if($meta->getAttribute('property')=='og:title'){
				$resp["title"]=$meta->getAttribute('content');
			}
			if($meta->getAttribute('property')=='og:description'){
				$resp["description"]=$meta->getAttribute('content');
			}
			if($meta->getAttribute('property')=='og:url'){
				$resp["url"]=$meta->getAttribute('content');
			}
			if($meta->getAttribute('property')=='og:image'){
				$resp["image"]=$meta->getAttribute('content');
			}
		}
		if(strlen($resp["title"])==0){
			$query = '/html/head/title';
			$titles = $xpath->query($query);
			foreach ($titles as $title) {
				$resp["title"]=$title->nodeValue;
			}
		}
		if(strlen($resp["description"])==0){
			$query = '//*/meta[starts-with(@name, \'description\')]';
			$descriptions = $xpath->query($query);
			foreach ($descriptions as $description) {
				$resp["description"]=$description->getAttribute('content');
			}
		}
		$query = '//*/meta[starts-with(@property, \'article:published_time\')]';
		$publisheds = $xpath->query($query);
		foreach ($publisheds as $published) {
			$resp["published_date"]=$published->getAttribute('content');
		}
		echo(json_encode($resp));
	}
	if($_POST['action']=="guardarLiga"){
		require_once("../dep/clases/DaoLigas.php");
		require_once("../dep/clases/DaoLigasSucesos.php");
		$DaoLigas=new DaoLigas();
		$DaoLigasSucesos=new DaoLigasSucesos();
		
		$Ligas=new Ligas();
		$Ligas->setBornDate(date("Y-m-d H:i:s"));
		$Ligas->setBornBy($Usuario->getId());
		if($_POST['Id']>0){
			$Ligas=$DaoLigas->show($_POST['Id']);
		}
		$Ligas->setURL($_POST['URL']);
		$Ligas->setTitle($_POST['Titulo']);
		$Ligas->setDescripcion($_POST['Descripcion']);
		$Ligas->setImagen($_POST['Imagen']);
		$FechaPublicacion=strtotime($_POST["AnioFechaNota"]."-".$_POST["MesFechaNota"]."-".$_POST["DiaFechaNota"]);
		$Ligas->setFechaPublicacion(date("Y-m-d",$FechaPublicacion));
		$nivelDetalleFecha="anio";
		$Fecha=$_POST['AnioFechaIni']."-01-01";
		if($_POST['MesFechaIni']!=="00"){
			$nivelDetalleFecha="mes";
			$Fecha=$_POST['AnioFechaIni']."-".$_POST['MesFechaIni']."-01";
			if($_POST['DiaFechaIni']>0){
				$nivelDetalleFecha="dia";
				$Fecha=$_POST['AnioFechaIni']."-".$_POST['MesFechaIni']."-".$_POST['DiaFechaIni'];
			}
		}
		$Ligas->setFechaIni($Fecha);
		$Ligas->setNivelDetalleFechaIni($nivelDetalleFecha);
		if($_POST["AnioFechaFin"]>0){
			$nivelDetalleFecha="anio";
			$Fecha=$_POST['AnioFechaFin']."-01-01";
			if($_POST['MesFechaFin']!=="00"){
				$nivelDetalleFecha="mes";
				$Fecha=$_POST['AnioFechaFin']."-".$_POST['MesFechaFin']."-01";
				if($_POST['DiaFechaFin']>0){
					$nivelDetalleFecha="dia";
					$Fecha=$_POST['AnioFechaFin']."-".$_POST['MesFechaFin']."-".$_POST['DiaFechaFin'];
				}
			}
			$Ligas->setFechaFin($Fecha);
			$Ligas->setNivelDetalleFechaFin($nivelDetalleFecha);
		}
		$Ligas=$DaoLigas->addOrUpdate($Ligas);
		if(!$_POST["Id"]>0){
			$LigasSucesos=new LigasSucesos();
			$LigasSucesos->setLiga($Ligas->getId());
			$LigasSucesos->setSuceso($_POST['Suceso']);
			$LigasSucesos=$DaoLigasSucesos->add($LigasSucesos);
		}
		echo(json_encode($Ligas));
	}
	
	if($_POST["action"]=="guardarTextoNota"){
		require_once("../dep/clases/DaoNotas.php");
		$DaoNotas=new DaoNotas();
		$Notas=new Notas();
		$Notas->setBornBy($Usuario->getId());
		$Notas->setDateBorn(date("Y-m-d H:i:s"));
		$Notas->setSuceso($_POST['Suceso']);
		if($_POST['Id']>0){
			$Notas=$DaoNotas->show($_POST['Id']);
		}
		$Notas->setNota($_POST['Texto']);
		$Notas->setLastUpdate(date("Y-m-d H:i:s"));
		$Notas=$DaoNotas->addOrUpdate($Notas);
		echo(json_encode($Notas));
	}
	if($_POST["action"]=="guardarCSSNota"){
		require_once("../dep/clases/DaoNotas.php");
		$DaoNotas=new DaoNotas();
		$Notas=new Notas();
		$Notas->setBornBy($Usuario->getId());
		$Notas->setDateBorn(date("Y-m-d H:i:s"));
		$Notas->setSuceso($_POST['Suceso']);
		if($_POST['Id']>0){
			$Notas=$DaoNotas->show($_POST['Id']);
		}
		$Notas->setCSS($_POST['Estilos']);
		$Notas->setLastUpdate(date("Y-m-d H:i:s"));
		$Notas=$DaoNotas->addOrUpdate($Notas);
		echo(json_encode($Notas));
	}
	if($_POST['action']=="addGoogleDriveFiles"){
		require_once("../dep/clases/DaoArchivos.php");
		$DaoArchivos=new DaoArchivos();
		$resp=array();
		foreach($_POST["Archivos"] as $Archivo){
			$Archivos=new Archivos();
			$Archivos->setSuceso($_POST['Suceso']);
			$Archivos->setDateBorn(date("Y-m-d H:i:s"));
			$Archivos->setBornBy($Usuario->getId());
			$Archivos->setServicio("GoogleDrive");
			$Archivos->setNombre($Archivo['nombre']);
			$Archivos->setUID($Archivo['uid']);
			$Archivos->setURL($Archivo['url']);
			$Archivos->setMimeType($Archivo['mimeType']);
			$Archivos->setIcon($Archivo['icon']);
			$Archivos=$DaoArchivos->add($Archivos);
			array_push($resp, $Archivos);
		}
		echo(json_encode($resp));
	}
}