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
						<label for="description" class="form-label">Descripción</label>
						<input
							type="text"
							name="description"
							v-model="form.description"
							class="form-control"
						/>
						<label for="rate" class="form-label">Tarifa</label>
						<input
							type="number"
							name="date"
							v-model="form.rate"
							class="form-control"
						/>
						<label for="name" class="form-label">Parcial Mínimo</label>
						<select
							class="form-select"
							aria-label="Default select example"
							v-model="form.partial_rate_id"
						>
							<option selected value="">Seleccione Parcial Mínimo</option>
							<option
								v-for="keep in partialRates"
								:key="keep.id"
								:value="keep.id"
							>
								{{ keep.attributes.name }}
							</option>
						</select>
						<label for="name" class="form-label">Tipo Habitacion</label>
						<select
							class="form-select"
							aria-label="Default select example"
							v-model="form.room_type_id"
						>
							<option selected value="">Seleccione Tipo Habitacion</option>
							<option
								v-for="keep in roomType"
								:key="keep.id"
								:value="keep.id"
							>
								{{ keep.attributes.name }}
							</option>
						</select>
						<label for="name" class="form-label"
							>Temática de la Habitación</label
						>
						<select
							class="form-select"
							aria-label="Default select example"
							v-model="form.theme_type_id"
						>
							<option selected value="">
								Seleccione Temática de la Habitación
							</option>
							<option
								v-for="keep in themeTypes"
								:key="keep.id"
								:value="keep.id"
							>
								{{ keep.attributes.name }}
							</option>
						</select>
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
					<div class="modal-footer">
						<a
							class="btn btn-danger text-white btn-icon-split mb-4"
							data-dismiss="modal"
						>
							<span class="text font-montserrat font-weight-bold"
								>Cancelar</span
							>
						</a>
						<a
							v-on:click.prevent="createPermission()"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<span class="text font-montserrat font-weight-bold"
								>Modificar Habitación</span
							>
						</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>

<script>
	import axios from "axios";
	import { dateFormat, getDateFormat } from "./helper";
	export default {
		name: "UpdateDateTemplate",
		components: {},

		mounted() {
			this.getRoomType();
		},
		data() {
			return {
				form: {
					id: "",
					room_type_id: "",
					rate: "",
					date: "",
				},
				roomType: [],
				partialRates: [],
				themeTypes: [],
				roomStatus: [],
			};
		},
		methods: {
			createPermission: function () {
				var url = "/room/" + this.form.id;
				axios
					.put(url, this.form)
					.then((response) => {
						this.errors = [];
						this.form = this.getClearFormObject();
						$("#exampleModal2").modal("hide");
						this.$emit("GetCreatedPermission");
					})
					.catch((error) => {});
			},
			getClearFormObject() {
				this.form = {
					id: "",
					room_type_id: "",
					date: "",
					rate: "",
				};
			},
			UpdateGetPermission(permission) {
				this.getRoomType();
				this.getPartialRate();
				this.getThemeType();
				this.getRoomStatus();
				this.form = {
					id: permission.id,
					description: permission.attributes.description,
					rate: permission.attributes.rate,
					partial_rate_id: permission.relationships.partialRate.id,
					room_type_id: permission.relationships.roomType.id,
					theme_type_id: permission.relationships.themeType.id,
					room_status_id: permission.relationships.roomStatus.id,
				};
			},
			getRoomType: function () {
				var urlKeeps = "/configuracion/room-type/get";
				axios
					.get(urlKeeps)
					.then((response) => {
						this.roomType = response.data.data;
					})
					.catch((err) => {});
			},
			getPartialRate() {
				var urlKeeps = "/configuracion/partial-rates/get";
				axios
					.get(urlKeeps)
					.then((response) => {
						this.partialRates = response.data.data;
					})
					.catch((err) => {});
			},
			getThemeType() {
				var urlKeeps = "/configuracion/theme-type/get";
				axios
					.get(urlKeeps)
					.then((response) => {
						this.themeTypes = response.data.data;
					})
					.catch((err) => {});
			},
			getRoomStatus() {
				var urlKeeps = "/configuracion/room-status/get";
				axios
					.get(urlKeeps)
					.then((response) => {
						this.roomStatus = response.data.data;
					})
					.catch((err) => {});
			},
		},
	};
</script>
