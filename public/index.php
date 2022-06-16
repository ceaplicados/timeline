<?php
require_once("../dep/interface.php");
require_once("../dep/clases/DaoTimelines.php");
$DaoTimelines=new DaoTimelines();

$title="Inicio";
$description="Dashboard de inicio";

interface_header($title,$description); ?>
<div class="container">
	<p>Bienvenidx <?php echo($Usuario->getSobrenombre()); ?><br/><?php echo($Cliente->getNombre()); ?></p>
	<h4>Selecciona un timeline</h4>
	<ul id="timelines">
		<?php foreach($DaoTimelines->getByCliente($Cliente->getId()) as $Timeline){ ?>
		<a href="timeline/<?php echo($Timeline->getNonce()); ?>">
		<li data-id="<?php echo($Timeline->getId()); ?>">
			<span class="nombre"><?php echo($Timeline->getNombre()); ?></span>
		</li>
		</a>
		<?php } ?>
		<li data-id="new" onclick="modalNuevoTimeline()"><i class="fas fa-plus-circle"></i><span>Añadir nuevo</span></li>
	</ul>
</div>
<!-- Modal -->
	<div class="modal fade" id="modalNuevoTimeline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="staticBackdropLabel">Nuevo timeline</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			  <form>
				  <div class="row">
					  <div class="form-group col-12 mb-3">
						  <label for="nombreTimeline">Nombre *</label>
						  <input type="text" class="form-control" id="nombreTimeline"  required/>
					  </div>
					  <div class="form-group col-12 mb-3">
						  <label for="descripcionTimeline">Descripción</label>
						  <textarea id="descripcionTimeline" class="form-control"  maxlength="255"></textarea>
					  </div>
				  </div>
			  </form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			<button type="button" class="btn btn-primary" id="nuevoTimeline" onclick="nuevoTimeline()">Crear</button>
		  </div>
		</div>
	  </div>
	</div>
<?php
interface_footer();