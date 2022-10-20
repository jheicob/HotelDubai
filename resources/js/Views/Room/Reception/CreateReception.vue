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
															
															<select
																name="tipo_documento"
																id="tipo_documento"
																required
																v-model="form.type_document_id"
																class="form-select"
															>
															<!-- ?php foreach ($tipo_documentos as $tipo_documento) : ?> -->
															<option value=''>Seleccione...</option>
															<option 
																	v-for="(type_document,i) in ocuppy.type_documents" 
																	:key=i
																	:value="type_document.id"
																	>
																	{{type_document.attributes.name}}
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
																v-model="form.document"
																@blur="ocuppy.getClient"
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
																v-model="form.first_name"
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
																Apellidos:
															</div>
															<input
																type="text"
																class="form-control"
																placeholder="Ingrese RUT"
																v-model="form.last_name"
																name="razon_social"
																id="razon_social"
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
																v-model="form.phone"
															/>
														</div>
														<!-- /.input group -->
													</div>
													<div class="form-group">
														<div class="input-group">
															
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
																v-model="form.email"
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
		<div class="row">
			<div class="col">
				<label class="form-label">Fecha de Entrada</label>
				<input
					v-model="date"
					type="date"
					class="form-control"
					:disabled="!client_exist"
				/>
			</div>
			<div class="col">
				<label class="form-label">Hora de Entrada</label>
				<input
					v-model="hour"
					type="time"
					class="form-control"
					:disabled="!client_exist"
				/>
			</div>
		</div>
<div>
			<label class="form-label">Cantidad de parciales</label>
			<input
				v-model="form.quantity_partial"
				type="number"
				class="form-control"
				:disabled="!client_exist"
			/>
			<div class="row">
				<div id="emailHelp" class="form-text col">
					Parcial mínimo:
					{{ item.attributes?.rate_current ?? "" }}
				</div>
				<div id="emailHelp" class="form-text col">
					Tarifa: $
					{{ item.relationships?.partialCost.attributes.rate ?? "" }}
				</div>
			</div>
		</div>
		<div>
			<label class="form-label">Observaciones</label>
			<input
				v-model="form.observation"
				type="text"
				class="form-control"
				:disabled="!client_exist"
			/>
		</div>

		<div class="row justify-content-between mt-4">
			<a class="btn btn-danger text-white btn-icon-split mb-4 col-3" @click="store.show = false">
				<span class="text font-montserrat font-weight-bold">Cancelar</span>
			</a>

			<button
				v-if="store.updated_reception"
				class="btn btn-success text-white btn-icon-split mb-4 col-3"
				>
				Facturar
			</button>

			<button
				:disabled="desactiveButton"
				v-on:click.prevent="storeAssignedRoom()"
				class="btn btn-primary text-white btn-icon-split mb-4 col-5"
			>
				<span class="text font-montserrat font-weight-bold"
					>Asignar Habitación</span
				>
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
import {ocuppyRoomStore} from '../Modals/OcuppyRoomStore'
import { RoomStore } from "../RoomStore";

const store = receptionStore();
const helper = HelperStore();
const ocuppy = ocuppyRoomStore();

	const { getClient, storeAssignedRoom } = ocuppy;

	const { form, item, desactiveButton } = storeToRefs(helper);
	const { client_exist, type_documents, date, hour } = storeToRefs(ocuppy);

	onMounted(() => {
		ocuppy.getTypeDocuments();
	});
</script>
