<?php
require_once("../dep/clases/DaooAuths.php");
require_once("../dep/clases/DaoUsuarios.php");
require_once("../dep/clases/DaoSessions.php");
// require_once("../dep/clases/DaoInvites.php");
require_once("../dep/clases/DaoUsuariosCliente.php");
$DaooAuths=new DaooAuths();
$DaoUsuarios=new DaoUsuarios();
$DaoSessions= new DaoSessions();
// $DaoInvites=new DaoInvites();
$DaoUsuariosCliente=new DaoUsuariosCliente();

if(isset($_GET["code"])){
	$url="https://www.googleapis.com/oauth2/v3/token";
	$addData=array();

	$data=array();
	array_push($data, "code=".$_GET["code"]);
	array_push($data, "client_id=".$DaooAuths->getParam("Google_ClientID"));
	array_push($data, "client_secret=".$DaooAuths->getParam("Google_ClientSecret"));
	array_push($data, "redirect_uri=https://".$DaooAuths->getParam("dominio")."/oauth/Google");
	array_push($data, "grant_type=authorization_code");
	$tokens=$DaooAuths->gweb_curl("POST", $addData, $url, $data);
	$tokens=json_decode($tokens);
	
	if(isset($tokens->error)){
		if(strlen($tokens->error)>0){
			header("Location: /login?error=".$tokens->error."&description=".$tokens->error_description);
			exit();
		}
	}
	
	$url="https://people.googleapis.com/v1/people/me?personFields=emailAddresses,names,photos&access_token=".$tokens->access_token;
	$addData=array();
	array_push($addData, "Authorization: Bearer ".$tokens->access_token);

	$data=array();
	$user_info=$DaooAuths->gweb_curl("GET", $addData, $url,false);
	$user_info=json_decode($user_info);
	$userId=str_replace("people/", "", $user_info->resourceName);
	$oAuths=$DaooAuths->getByServicioUID('Google',$userId);
	if($oAuths->getId()>0){
		$Usuario=$DaoUsuarios->show($oAuths->getUsuario());

		// Actualizar tokens
		$oAuths->setAccessKey($tokens->access_token);
		if(isset($tokens->refresh_token)){
			if(strlen($tokens->refresh_token)>0){
				$oAuths->setRefreshKey($tokens->refresh_token);
			}
		}
		$oAuths->setNeedsReauthorization(0);
		$DaooAuths->update($oAuths);
		
		// crear sesión sin cliente
		$Session = new Sessions();

		if(isset($_COOKIE["SessionUID"])){
			$Session=$DaoSessions->getSession($_COOKIE["SessionUID"]);
			if($Session->getId()>0){
				// renovar por 48 horas
				$Session->setDateDeath(date("Y-m-d H:i:s",strtotime("+48 hours")));
				$DaoSessions->update($Session);
			}else{
				header("Location: ../../cloud/logout.php");
				exit();
			}
		}
		if(!$Session->getId()>0){
			$Session->setUID($DaoSessions->nonce(),25);
			$Session->setUsuario($Usuario->getId());
			$Session->setDateBorn(date("Y-m-d H:i:s"));
			$Session->setDateDeath(date("Y-m-d H:i:s",strtotime("+48 hours")));
			$Session=$DaoSessions->add($Session);
		}
	}else{
		if(isset($_COOKIE["SessionUID"])){
			$Session=$DaoSessions->getSession($_COOKIE["SessionUID"]);
			// renovar por 48 horas
			if($Session->getId()>0){
				$Session->setDateDeath(date("Y-m-d H:i:s",strtotime("+48 hours")));
				$DaoSessions->update($Session);
				$Usuario=$DaoUsuarios->show($Session->getUsuario());
			}else{
				header("Location: ../../logout");
				exit();
			}
		}else{
			$Usuario = new Usuarios();
			// Buscar por email al usuario
			foreach($user_info->emailAddresses as $emailObj){
				$SearchUsuario=$DaoUsuarios->getByEmail($emailObj->value);
				if($SearchUsuario->getId()>0){
					$Usuario=$SearchUsuario;
				}
			}
			if(!$Usuario->getId()>0){
				$image="";
				if(count($user_info->photos)>0){
					$image=$user_info->photos[0]->url;
				}
				// Crear un usuario nuevo
				$Usuario->setSobrenombre($user_info->names[0]->givenName);
				$Usuario->setNombre($user_info->names[0]->displayName);
				$Usuario->setEmail($user_info->emailAddresses[0]->value);
				$Usuario->setDateBorn(date("Y-m-d H:i:s"));
				$Usuario->setActivo(1);
				$Usuario->setImage($image);
				$Usuario->setUUID($DaoUsuarios->nonce());
				$Usuario=$DaoUsuarios->add($Usuario);
			}
			// Crear sessión nueva
			$Session = new Sessions();
			$Session->setUID($DaoSessions->nonce("",25));
			$Session->setUsuario($Usuario->getId());
			$Session->setDateBorn(date("Y-m-d H:i:s"));
			$Session->setDateDeath(date("Y-m-d H:i:s",strtotime("+48 hours")));
			$Session=$DaoSessions->add($Session);
		}
		
		// poner tokens
		$oAuths=new oAuths();
		$oAuths->setUsuario($Usuario->getId());
		$oAuths->setServicio("Google");
		$oAuths->setUID($userId);
		$oAuths->setAccessKey($tokens->access_token);
		$oAuths->setRefreshKey($tokens->refresh_token);
		$oAuths->setDateBorn(date("Y-m-d H:i:s"));
		$oAuths->setNeedsReauthorization(0);
		$oAuths=$DaooAuths->add($oAuths);
	}
	
	// poner cookie de sesión
	setcookie("SessionUID", $Session->getUID(), time() + (86400 * 2), "/"); 

	if($_GET["state"]=="login"){
		header("Location: ../../cambiar_org");
		exit();
	}
	/*
	if(strpos($_GET["state"], "nvite_")>0){
		$Key_Invite=substr($_GET["state"], 7);
		$Invite=$DaoInvites->advanced_query("SELECT * FROM invites WHERE UID='$Key_Invite'");
		if(count($Invite)>0){
			$Invite=$Invite[0];
			$UsuariosCliente = new UsuariosCliente();
			$UsuariosCliente->setUsuario($Usuario->getId());
			$UsuariosCliente->setCliente($Invite->getCliente());
			$UsuariosCliente->setBornBy($Invite->getBornBy());
			$UsuariosCliente->setBornByTipo("usu");
			$UsuariosCliente->setDateBorn(date("Y-m-d H:i:s"));
			$DaoUsuariosCliente->add($UsuariosCliente);

			$Session->setCliente($Invite->getCliente());
			$DaoSessions->update($Session);

			$Invite->setUID("");
			$DaoInvites->update($Invite);
			
			header("Location: ../../cloud/index.php");
			exit();
		}
		
	}
	*/
}