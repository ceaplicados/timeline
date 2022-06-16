<?php
require_once("../dep/interface.php");
require_once("../dep/clases/DaoTimelines.php");
$DaoTimelines=new DaoTimelines();

$nonce=$_SERVER["REQUEST_URI"];
$nonce=str_replace("timeline", "", $nonce);
$nonce=str_replace("/", "", $nonce);

$timeline=$DaoTimelines->getByNonce($nonce);
if(!$timeline->getId()>0){
	header("Location: /?error=noTimeline");
	exit();
}
$title=$timeline->getNombre();
$description=$timeline->getDescripcion();
interface_timeline_head($title,$description)
?>
<div id="interface">
	<a class="navbar-brand" id="logoTimeline" href="../"><img src="/assets/img/logo.svg"  /></a>
	<h1><?php echo($title); ?></h1>
	<div id="menuHerramientas">
		<i class="fas fa-cog" id="cogMenuHerramientas"></i>
		<i class="fas fa-plus" id="addSuceso" title="Añadir suceso" onclick="modalSuceso()"></i>
		<a href="/print/<?php echo($timeline->getNonce()); ?>" target="_blank"><i class="fas fa-print" id="goPrint" title="Imprimir"></i></a>
	</div>
	<div id="timeline">
		<div id="fechaIni" class="oculto"></div>
		<div id="fechaFin" class="oculto"></div>
	</div>
	<div id="detalleSuceso" class="notasSuceso">
		<div class="sombra" onclick="cerrarSuceso()"></div>
		<div class="contenidos">
			<i class="far fa-times-circle" onclick="cerrarSuceso()" title="Cerrar ventana"></i>
			<h2 class="nombreSuceso"></h2>
			<p class="descripcion"></p>
			<p class="text-end"><button type="button" class="btn btn-outline-primary"  onclick="modalSuceso(this)">Editar</button></p>
			<ul class="tabSelector">
				<li data-target="ligasSuceso">Ligas</li>
				<li data-target="notasSuceso">Notas</li>
				<li data-target="googleDrive">Archivos en Drive</li>
			</ul>
			<div id="ligasSuceso">
				<h3>Ligas de referencia <i class="fas fa-plus" id="addLiga" title="Añadir liga de referencia" onclick="modalLiga()"></i></h3>
				<ul class="ligas"></ul>
			</div>
			<div id="notasSuceso">
				<h3>Notas <i class="fas fa-plus" id="addNota" title="Añadir notas sobre el suceso" onclick="addNota()"></i></h3>
				<div class="listaNotas"></div>
			</div>
			<div id="googleDrive">
				<p><a class="btn btn-outline-primary" onclick="createDrivePicker()">Añadir archivo de Google Drive</a></p>
				<ul class="archivos"></ul>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
	<div class="modal fade" id="modalSuceso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Nuevo suceso</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			  <form>
				  <div class="row">
					  <div class="form-group col-12 mb-3">
						  <label for="nombreSuceso">Nombre *</label>
						  <input type="text" class="form-control" id="nombreSuceso"  required/>
					  </div>
					  <p class="exactaFechaIni">Inicia en:</p>
					  <p class="rangoFechaIni">Inicia entre:</p>
					  <div class="form-group col-3 mb-3">
						  <label for="anioFechaIni">Año</label>
						  <input type="number" placeholder="AAAA" class="form-control" id="anioFechaIni"  required/>
					  </div>
					  <div class="form-group col-5 mb-3">
							<label for="mesFechaIni">Mes</label>
							<select class="form-control" id="mesFechaIni">
								<option value="00">Sin especificar</option>
								<option value="01">Enero</option>
								<option value="02">Febrero</option>
								<option value="03">Marzo</option>
								<option value="04">Abril</option>
								<option value="05">Mayo</option>
								<option value="06">Junio</option>
								<option value="07">Julio</option>
								<option value="08">Agosto</option>
								<option value="09">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
							</select>
						</div>
						<div class="form-group col-4 mb-3">
						  <label for="diaFechaIni">Día</label>
						  <input type="number" class="form-control" id="diaFechaIni" placeholder="Sin especificar" />
						</div>
						<p class="rangoFechaIni">y el:</p>
						<div class="form-group col-3 mb-3 rangoFechaIni">
						  <label for="anioFechaIni1">Año</label>
						  <input type="number" placeholder="AAAA" class="form-control" id="anioFechaIni1"  required/>
					  </div>
					  <div class="form-group col-5 mb-3 rangoFechaIni">
							<label for="mesFechaIni1">Mes</label>
							<select class="form-control" id="mesFechaIni1">
								<option value="00">Sin especificar</option>
								<option value="01">Enero</option>
								<option value="02">Febrero</option>
								<option value="03">Marzo</option>
								<option value="04">Abril</option>
								<option value="05">Mayo</option>
								<option value="06">Junio</option>
								<option value="07">Julio</option>
								<option value="08">Agosto</option>
								<option value="09">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
							</select>
						</div>
						<div class="form-group col-4 mb-3 rangoFechaIni">
						  <label for="diaFechaIni1">Día</label>
						  <input type="number" class="form-control" id="diaFechaIni1" placeholder="Sin especificar" />
						</div>
						<div class="form-check form-check-inline text-end col-12 mb-3">
							  <input type="checkbox" class="form-check-input" id="rangoFechaInicial" onchange="toggleRangoFechaIni()" />
							  <label class="form-check-label" for="rangoFechaInicial">Establecer un rango de fechas de inicio</label>
						</div>
						<hr/>
						<p class="exactaFechaFin">Finaliza en:</p>
						  <p class="rangoFechaFin">Finaliza entre:</p>
						  <div class="form-group col-3 mb-3">
							  <label for="anioFechaFin">Año</label>
							  <input type="number" placeholder="AAAA" class="form-control" id="anioFechaFin"  required/>
						  </div>
						  <div class="form-group col-5 mb-3">
								<label for="mesFechaFin">Mes</label>
								<select class="form-control" id="mesFechaFin">
									<option value="00">Sin especificar</option>
									<option value="01">Enero</option>
									<option value="02">Febrero</option>
									<option value="03">Marzo</option>
									<option value="04">Abril</option>
									<option value="05">Mayo</option>
									<option value="06">Junio</option>
									<option value="07">Julio</option>
									<option value="08">Agosto</option>
									<option value="09">Septiembre</option>
									<option value="10">Octubre</option>
									<option value="11">Noviembre</option>
									<option value="12">Diciembre</option>
								</select>
							</div>
							<div class="form-group col-4 mb-3">
							  <label for="diaFechaFin">Día</label>
							  <input type="number" class="form-control" id="diaFechaFin" placeholder="Sin especificar" />
							</div>
							<p class="rangoFechaFin">y el:</p>
							<div class="form-group col-3 mb-3 rangoFechaFin">
							  <label for="anioFechaFin1">Año</label>
							  <input type="number" class="form-control" id="anioFechaFin1"  placeholder="AAAA" required/>
						  </div>
						  <div class="form-group col-5 mb-3 rangoFechaFin">
								<label for="mesFechaFin1">Mes</label>
								<select class="form-control" id="mesFechaFin1">
									<option value="00">Sin especificar</option>
									<option value="01">Enero</option>
									<option value="02">Febrero</option>
									<option value="03">Marzo</option>
									<option value="04">Abril</option>
									<option value="05">Mayo</option>
									<option value="06">Junio</option>
									<option value="07">Julio</option>
									<option value="08">Agosto</option>
									<option value="09">Septiembre</option>
									<option value="10">Octubre</option>
									<option value="11">Noviembre</option>
									<option value="12">Diciembre</option>
								</select>
							</div>
							<div class="form-group col-4 mb-3 rangoFechaFin">
							  <label for="diaFechaFin1">Día</label>
							  <input type="number" class="form-control" id="diaFechaFin1" placeholder="Sin especificar" />
							</div>
							<div class="form-check form-check-inline text-end col-12 mb-3">
								  <input type="checkbox" class="form-check-input" id="rangoFechaFinal" onchange="toggleRangoFechaFin()" />
								  <label class="form-check-label" for="rangoFechaFinal">Establecer un rango de fechas de fin</label>
							</div>
					  <div class="form-group col-12 mb-3">
						  <label for="descripcionSuceso">Descripción</label>
						  <textarea id="descripcionSuceso" class="form-control"  maxlength="255"></textarea>
					  </div>
				  </div>
			  </form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			<button type="button" class="btn btn-primary" id="guardarSuceso" onclick="guardarSuceso()">Crear</button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="modalLiga" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title">Liga</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				  <form>
					<div class="row">
						<div class="form-group col-12  mb-3">
							<label for="urlLiga">URL de la liga</label>
							<input type="text" class="form-control" id="urlLiga"  required/>
						</div>
						<p class="text-end mb-3"><button type="button" class="btn btn-outline-primary" id="extraerLiga" onclick="do_extraerLiga()">Extraer liga</button></p>
						<div class="col-12">
							<div class="row">
								<div class="col-4">
									<div id="imagenLiga"></div>
								</div>
								<div class="col-8">
									<div class="form-group col-12 mb-3">
										<label for="tituloLiga">Título</label>
										<input type="text" class="form-control" id="tituloLiga"  required/>
									</div>
									<div class="form-group col-12 mb-3">
										<label for="descripcionLiga">Descripción</label>
										<textarea id="descripcionLiga" class="form-control" maxlength="255"></textarea>
									</div>
								</div>
							</div>
						</div>
						
						<p>Fecha de publicación:</p>
						<div class="form-group col-3 mb-3">
							<label for="anioFechaNota">Año</label>
							<input type="number" placeholder="AAAA" class="form-control" id="anioFechaNota" />
						</div>
						<div class="form-group col-5 mb-3">
							<label for="mesFechaNota">Mes</label>
							<select class="form-control" id="mesFechaNota">
								<option value="01">Enero</option>
								<option value="02">Febrero</option>
								<option value="03">Marzo</option>
								<option value="04">Abril</option>
								<option value="05">Mayo</option>
								<option value="06">Junio</option>
								<option value="07">Julio</option>
								<option value="08">Agosto</option>
								<option value="09">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
							</select>
						</div>
						<div class="form-group col-4 mb-3">
							<label for="diaFechaNota">Día</label>
							<input type="number" class="form-control" id="diaFechaNota" />
						</div>
						<div class="col-12">
							<div class="row">
								<div class="col-4"></div>
								<div class="col-8">
									<p>Periodo de tiempo al que se hace referencia en la liga:</p>
									<div class="row">
										<div class="form-group col-3 mb-3">
											<label for="anioFechaIniLiga">Año</label>
											<input type="number" placeholder="AAAA" class="form-control" id="anioFechaIniLiga"  required/>
										</div>
										<div class="form-group col-5 mb-3">
											<label for="mesFechaIniLiga">Mes</label>
											<select class="form-control" id="mesFechaIniLiga">
												<option value="00">Sin especificar</option>
												<option value="01">Enero</option>
												<option value="02">Febrero</option>
												<option value="03">Marzo</option>
												<option value="04">Abril</option>
												<option value="05">Mayo</option>
												<option value="06">Junio</option>
												<option value="07">Julio</option>
												<option value="08">Agosto</option>
												<option value="09">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</div>
										<div class="form-group col-4 mb-3">
											<label for="diaFechaIniLiga">Día</label>
											<input type="number" class="form-control" id="diaFechaIniLiga" placeholder="Sin especificar" />
										</div>
										<p>al</p>
										<div class="form-group col-3 mb-3">
											<label for="anioFechaFinLiga">Año</label>
											<input type="number" placeholder="AAAA" class="form-control" id="anioFechaFinLiga"  required/>
										</div>
										<div class="form-group col-5 mb-3">
											<label for="mesFechaFinLiga">Mes</label>
											<select class="form-control" id="mesFechaFinLiga">
												<option value="00">Sin especificar</option>
												<option value="01">Enero</option>
												<option value="02">Febrero</option>
												<option value="03">Marzo</option>
												<option value="04">Abril</option>
												<option value="05">Mayo</option>
												<option value="06">Junio</option>
												<option value="07">Julio</option>
												<option value="08">Agosto</option>
												<option value="09">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</div>
										<div class="form-group col-4 mb-3">
											<label for="diaFechaFinLiga">Día</label>
											<input type="number" class="form-control" id="diaFechaFinLiga" placeholder="Sin especificar" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				  </form>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="guardarLiga" onclick="guardarLiga()">Guardar</button>
			  </div>
			</div>
		  </div>
		</div>
<input type="hidden" id="timeline_nonce" value="<?php echo($timeline->getNonce()); ?>">
<?php
interface_footer(true);