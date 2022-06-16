<?php
require_once("../dep/interface.php");
$ClientesUsuario=$DaoCliente->getByUsuario($Usuario->getId());
if(count($ClientesUsuario)==1){
	$Session->setCliente($ClientesUsuario[0]->getId());
	$DaoSessions->update($Session);
	header("Location: dashboard");
	exit();
}
$title="Selecciona la organización";
$description="Interfaz para cambiar de organización de trabajo";
interface_header($title,$description); ?>
<div class="container">
	<p>Selecciona la organización con la que quieres trabajar</p>
</div>
<?php
interface_footer();