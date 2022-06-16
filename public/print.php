<?php
require_once("../dep/interface.php");
require_once("../dep/clases/DaoTimelines.php");
require_once("../dep/clases/DaoSucesos.php");
require_once("../dep/clases/DaoLigas.php");
require_once("../dep/clases/DaoNotas.php");

$DaoTimelines=new DaoTimelines();
$DaoSucesos=new DaoSucesos();
$DaoLigas=new DaoLigas();
$DaoNotas=new DaoNotas();

$nonce=$_SERVER["REQUEST_URI"];
$nonce=str_replace("print", "", $nonce);
$nonce=str_replace("/", "", $nonce);

$timeline=$DaoTimelines->getByNonce($nonce);
if(!$timeline->getId()>0){
	header("Location: /?error=noTimeline");
	exit();
}
$title=$timeline->getNombre();
$description=$timeline->getDescripcion();
interface_timeline_head($title,$description,"print");
?>
<h1><?php echo($timeline->getNombre()); ?></h1>
<p><?php echo($timeline->getDescripcion()); ?></p>
<?php foreach($DaoSucesos->getByTimeline($timeline->getId()) as $Suceso){ ?>
<div class="suceso">
	<h2><?php echo($Suceso->getNombre()); ?></h2>
	<p><?php echo($Suceso->getDescripcion()); ?></p>
	<p><i><?php echo($DaoSucesos->formatFecha($Suceso->getFechaIni())); ?> - <?php echo($DaoSucesos->formatFecha($Suceso->getFechaFin())); ?></i></p>
	<?php $Ligas=$DaoLigas->getBySuceso($Suceso->getId()); 
	if(count($Ligas)>0){ ?>
	<div class="ligas">
		<h3>Ligas de referencia</h3>
		<?php foreach($Ligas as $Liga){ ?>
		<div class="liga">
			<h4><?php echo($Liga->getTitle()); ?></h4>
			<p><?php echo($Liga->getDescripcion()); ?></p>
			<p><i><?php echo($Liga->getFechaIni()); ?> - <?php echo($Liga->getFechaFin()); ?></i></p>
			<p><a href="<?php echo($Liga->getURL()); ?>"><?php echo($Liga->getURL()); ?></a></p>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	<?php $Notas=$DaoNotas->getBySuceso($Suceso->getId()); 
	if(count($Notas)>0){ ?>
	<div class="notas">
		<h3>Notas</h3>
		<?php foreach($Notas as $Nota){ ?>
		<div class="nota">
			<p><?php echo($Nota->getNota()); ?></p>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<?php } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Fecha de impresión: <?php echo($DaoLigas->formatFecha(date("Y-m-d"))." ".date("H:i:s")); ?></p>
<?php
interface_footer(true);