<template>
	<div class="row">
		<!-- col -->
		<div class="col-md-12">
			<section class="tile">
				<div class="tile-header dvd dvd-btm">
					<div class="box-header with-border">
						<h3 class="box-title">Datos de la habitación</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="table-responsive">
							<table class="table no-margin">
								<tbody style="padding: 0px">
									<tr style="padding: 0px">
										<td>
											<h4
												class="text-primary"
												style="margin-top: 0px !important"
											>
												Nombre:
											</h4>
										</td>
										<td>{{item.attributes?.name ?? ''}}</td>
										<td>
											<h4
												class="text-primary"
												style="margin-top: 0px !important"
											>
												Tipo:
											</h4>
										</td>
										<td>
											<div
												class="sparkbar"
												data-color="#00a65a"
												data-height="20"
											>
											{{item.relationships?.partialCost.relationships.roomType.attributes.name ?? ''}}
											</div>
										</td>
									</tr>
									<tr style="padding: 0px">
										<td>
											<h4
												class="text-primary"
												style="margin-top: 0px !important"
											>
												Detalles:
											</h4>
										</td>
										<td>
											{{item.attributes?.description ?? ''}}
											</td>
										<td>
											<h4
												class="text-primary"
												style="margin-top: 0px !important"
											>
												Estado:
											</h4>
										</td>
										<td>
											<div
												class="sparkbar"
												data-color="#f39c12"
												data-height="20"
											>
												<span class="label label-success"
													>DISPONIBLE</span
												>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.table-responsive -->
					</div>
				</div>
				<!-- /.box -->
				<!-- Modal -->
				<form
					class="form-horizontal"
					method="post"
					id="addproduct"
					action="index.php?view=addproceso"
					role="form"
				>
					<div class="box box-info row">
						<div class="box-body col-md-6">
							<div class="table-responsive">
								<div class="">
									<table class="table no-margin">
										<tr>
											<th colspan="4" style="text-align: center">
												DATOS DEL CLIENTE
												<div class="col-md-2"></div>
											</th>
										</tr>
										<tbody style="padding: 0px">
											<tr style="padding: 0px">
												<td colspan="2">
													<div class="form-group">
														<div class="input-group">
															<div
																class="input-group-addon"
															>
																<i
																	class="fa fa-globe"
																></i>
																Tipo Documento:
															</div>
															?php $tipo_documentos =
															TipoDocumentoData::getAll();
															?>
															<select
																name="tipo_documento"
																id="tipo_documento"
																required
																class="form-control"
															>
																<!-- ?php foreach ($tipo_documentos as $tipo_documento) : ?> -->
																<option
																	value="?php echo $tipo_documento->id; ?>"
																>
																	?php echo
																	$tipo_documento->nombre;
																	?>
																</option>
																<!-- ?php endforeach; ?> -->
															</select>
															<div
																class="input-group-addon"
															>
																<i
																	class="fa fa-arrow-circle-o-right"
																></i>
																Documento:
															</div>
															<input
																type="text"
																class="form-control"
																name="documento"
																id="documento"
																required="required"
																placeholder="Ingresar documento para buscar"
															/>
															<input
																type="hidden"
																id="id"
															/>
														</div>
														<!-- /.input group -->
													</div>
													<div class="form-group">
														<div class="input-group">
															<div
																class="input-group-addon"
															>
																Nombres:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															</div>
															<input
																type="text"
																class="form-control"
																name="nombre"
																id="nombre"
																required
																placeholder="Ingrese nombres"
															/>
														</div>
														<!-- /.input group -->
													</div>
													<div class="form-group">
														<div class="input-group">
															<div
																class="input-group-addon"
															>
																RUT:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															</div>
															<input
																type="text"
																class="form-control"
																placeholder="Ingrese RUT"
																name="razon_social"
																id="razon_social"
																value=""
															/>
															<div
																class="input-group-addon"
															>
																Teléfono:
															</div>
															<input
																type="text"
																class="form-control"
																placeholder="Ingrese teléfono"
																name="telefono"
																id="telefono"
																required
																value=""
															/>
														</div>
														<!-- /.input group -->
													</div>
													<div class="form-group">
														<div class="input-group">
															<div
																class="input-group-addon"
															>
																Procedencia:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															</div>
															<input
																type="text"
																class="form-control"
																name="nacionalidad"
																id="nacionalidad"
																placeholder="Ingrese procedencia (No es obligatorio)"
																data-inputmask='"mask": "(999) 999-9999"'
																data-mask
															/>
															<div
																class="input-group-addon"
															>
																E-mail:
															</div>
															<input
																type="text"
																class="form-control"
																name="direccion"
																id="direccion"
																required
																placeholder="Ingrese correo electronico "
															/>
														</div>
														<!-- /.input group -->
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<table class="table no-margin">
								<thead>
									<tr>
										<th colspan="4" style="text-align: center">
											DATOS DEL ALOJAMIENTO
										</th>
									</tr>
								</thead>
								<tbody style="padding: 0px">
									<tr style="padding: 0px">
										<td colspan="3">
											<!-- Date dd/mm/yyyy -->
											<div class="form-group">
												<label>Tarifa:</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-globe"></i>
													</div>
													<select
														class="form-control"
														onchange="CargarTarifa(this.value);"
														required
														name="id_tarifa"
													>
														<!-- ?php $tarifas_ha = TarifaHabitacionData::getAllHabitacion($_GET['id_habitacion']); ?> -->
														<option value="">
															--- Selecciona ---
														</option>
														<!-- ?php foreach ($tarifas_ha as $tarifa_ha) : ?> -->
														<option
															value="?php echo $tarifa_ha->id; ?>"
														>
															?php echo
															$tarifa_ha->getTarifa()->nombre;
															?>
														</option>
														<!-- ?php endforeach; ?> -->
													</select>
												</div>
												<!-- /.input group -->
											</div>
											<div
												class="form-group"
												id="mostrar_precio"
											></div>
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														Cant. de personas:
													</div>
													<select
														class="form-control"
														name="cantidad"
													>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
													</select>
												</div>
												<!-- /.input group -->
											</div>
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														Estado de pago
														&nbsp;&nbsp;&nbsp;&nbsp;
													</div>
													<select
														class="form-control"
														name="pagado"
														onchange="MostrarSelectMedioPago(this.value);"
														required
													>
														<option value="">
															--- Selecciona ---
														</option>
														<option value="1">Pagado</option>
														<option value="0">
															Falta pagar
														</option>
													</select>
												</div>
												<!-- /.input group -->
											</div>
											<!-- Date dd/mm/yyyy -->
											<div
												class="form-group"
												id="mostrar_selectmediopago"
											>
												<!-- /.input group -->
											</div>
											<div
												class="form-group"
												id="mostrar_mediopago"
											></div>
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														Fecha
														salida&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													</div>
													<input
														type="text"
														class="form-control"
														name="fecha_salida"
														id="fecha_salida"
														value="?php echo $nuevafecha; ?>"
														data-inputmask='"mask": "(999) 999-9999"'
														data-mask
													/>
													<div class="input-group-addon">
														Hora salida
													</div>
													<input
														type="time"
														class="form-control"
														name="hora_salida"
														value="?php echo $doce; ?>"
													/>
												</div>
												<!-- /.input group -->
											</div>
											<div class="box-footer">
												<a
													href="#"													
													class="btn btn-danger"
													@click="store.hiddenReception"
													>Cancelar</a
												>
												<input
													type="hidden"
													name="id_habitacion"
													value="?php echo $habitacion->id; ?>"
												/>
												<button
													type="submit"
													class="btn btn-success pull-right"
												>
													Registrar ingreso
												</button>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- /.table-responsive -->
				</form>
			</section>
		</div>
	</div>
</template>
<script setup>
import {onMounted} from 'vue'
import {storeToRefs} from 'pinia'
import {receptionStore} from './ReceptionStore.js'
import {HelperStore} from '@/HelperStore'

const store = receptionStore();
const helper = HelperStore();

const {item} = storeToRefs(helper)
onMounted( () =>{
	console.log('crear reception')
} )
</script>
