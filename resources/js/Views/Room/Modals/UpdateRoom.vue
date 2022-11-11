<template>
	<form>
		<!-- Modal -->
		<div
			class="modal fade"
			id="exampleModal2"
			tabindex="-1"
			role="dialog"
			aria-labelledby="exampleModalLabel"
			aria-hidden="true"
		>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header py-2">
						<h5
							class="modal-title title-page text-secondary"
							id="exampleModalLabel"
						>
							Modificar Habitación
						</h5>
						<a
							type="button"
							class="close"
							data-dismiss="modal"
							aria-label="Close"
						>
							<span aria-hidden="true">&times;</span>
						</a>
					</div>
					<div class="modal-body">
						<div v-if="useHelper.permiss.updated">
							<label for="description" class="form-label"
								>Número de Habitación</label
							>
							<input
								type="text"
								name="description"
								v-model="form.name"
								class="form-control"
							/>
							<label for="description" class="form-label"
								>Descripción</label
							>
							<input
								type="text"
								name="description"
								v-model="form.description"
								class="form-control"
							/>
							<label for="name" class="form-label">Tipo Habitacion</label>
							<select
								class="form-select"
								aria-label="Default select example"
								v-model="room_type_id"
								@change="getPartialCost"
							>
								<option selected value="">
									Seleccione Tipo Habitacion
								</option>
								<option
									v-for="keep in roomType"
									:key="keep.id"
									:value="keep.id"
								>
									{{ keep.attributes.name }}
								</option>
							</select>
							<label for="name" class="form-label">Pertenece a:</label>
							<select
								class="form-select"
								aria-label="Default select example"
								v-model="form.estate_type_id"
							>
								<option selected value="">
									Seleccione tipo de inmueble
								</option>
								<option
									v-for="keep in useStore.estateTypes"
									:key="keep.id"
									:value="keep.id"
								>
									{{ keep.attributes.name }}
								</option>
							</select>
						</div>
						<div v-if="useHelper.permiss.change_parcial">
							<label for="name" class="form-label">Parcial Mínimo</label>
							<select
								class="form-select"
								aria-label="Default select example"
								v-model="form.partial_cost_id"
								:disabled="partialCost.length < 1"
							>
								<option selected value="">
									Seleccione Parcial Mínimo
								</option>
								<option
									v-for="keep in partialCost"
									:key="keep.id"
									:value="keep.id"
								>
									({{ keep.relationships.partialRate.attributes.name }})
									$
									{{ keep.attributes.rate }}
								</option>
							</select>
							<label for="rate" class="form-label">Tarifa</label>
							<div class="form-inline">
								<input
									disabled
									type="number"
									name="date"
									v-model="getRate"
									class="form-control col-4"
								/>
							</div>
						</div>
						<div v-if="useHelper.permiss.free">
							<label for="name" class="form-label"
								>Estado de la Habitación</label
							>
							<select
								class="form-select"
								aria-label="Default select example"
								v-model="form.room_status_id"
							>
								<option selected value="">
									Seleccione Estado de la Habitación
								</option>
								<option
									v-for="keep in roomStatus"
									:key="keep.id"
									:value="keep.id"
								>
									{{ keep.attributes.name }}
								</option>
							</select>
						</div>
						<div class="form-check" v-if="useHelper.permiss.in_repair">
							<input
								class="form-check-input"
								type="checkbox"
								v-model="answer_repair"
								id="flexCheckDefault"
							/>
							<label class="form-check-label" for="flexCheckDefault">
								¿Necesita Reparación?
							</label>
						</div>
						<div class="form-floating" v-if="answer_repair">
							<textarea
								class="form-control"
								v-model="form_repair.description"
								placeholder="Leave a comment here"
								id="floatingTextarea"
							></textarea>
							<label for="floatingTextarea"
								>Describe el problema (la habitación quedará fuera de
								servicio)</label
							>
						</div>
						<div
							class="form-floating mt-4"
							v-if="
								form_repair.description != '' && useHelper.permiss.repair
							"
						>
							<textarea
								class="form-control"
								v-model="form_repair.observation"
								placeholder="Leave a comment here"
								id="floatingTextarea"
							></textarea>
							<label for="floatingTextarea"
								>Escribe lo que se solucionó (la habitación estará
								disponible)</label
							>
						</div>
					</div>
					<div class="modal-footer">
						<a
							class="btn btn-danger text-white btn-icon-split mb-4"
							data-dismiss="modal"
						>
							<span class="text font-montserrat font-weight-bold"
								>Cancelar</span
							>
						</a>
						<button
							:disabled="desactiveButton"
							v-on:click.prevent="updateRoom"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<span class="text font-montserrat font-weight-bold"
								>Modificar Habitación</span
							>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>

<script setup>
	import { HelperStore } from "@/HelperStore";
	import { RoomStore } from "../RoomStore";
	import { onMounted, ref } from "vue";
	import { storeToRefs } from "pinia";

	const useHelper = HelperStore();
	const useStore = RoomStore();

	const { getRoomType, getRoomStatus, getPartialCost, formatForm } = useStore;
	const {
		form_repair,
		answer_repair,
		roomStatus,
		roomType,
		partialCost,
		room_type_id,
		getRate,
	} = storeToRefs(useStore);
	const { putItem, clearForm } = useHelper;
	const { form, desactiveButton } = storeToRefs(useHelper);

	function updateRoom() {
let option = `room_status_id=${useStore.btn_room_status_id ?? ''}&estate_type_id=${useStore.estate_type_id}`;

			putItem(formatForm,option);

			if (useStore.answer_repair) {
				axios
					.put("room/repair", useStore.form_repair)
					.then(() => {
						form_repair.value = {
							room_id: "",
							description: "",
							observation: "",	
						};
					});
			}
	}
	onMounted(() => {
		getPartialCost();
		getRoomType();
		getRoomStatus();
		useStore.getEstateTypes();
	});
</script>
