<template>
	<form>
		<!-- Modal -->
		<div
			class="modal fade"
			id="exampleModal"
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
							Crear plantilla de Hora
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

						<div class="form-inline text-center my-3">
							<label for="hour" class="form-label">Hora Inicio</label>
							<input
								class="form-control col-3"
								name="hour"
								type="time"
								v-model="form.hour"
							/>
							<label for="hour" class="form-label ml-3 mr-1"
								>Hora Fin</label
							>
							<input
								class="form-control col-3"
								name="hour"
								type="time"
								v-model="form.hour_end"
							/>
						</div>
						<label for="rate" class="form-label">Tarifa</label>
						<input
							class="form-control"
							name="rate"
							type="number"
							v-model="form.rate"
						/>
<label for="name" class="form-label">Parcial Minimo</label>
						<select
							class="form-select"
							aria-label="default select example"
							v-model="form.partial_rate_id"
						>
							<option selected value="">seleccione Parcial Minimo</option>
							<option
								v-for="keep in partialRates"
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
								>Crear plantilla de Hora</span
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
	export default {
		name: "PartialCostCreate",
		components: {},

		created() {
			this.getRoomType();
			this.getPartialRate()
			this.getShiftSystem();
		},
		data() {
			return {
				form: this.getClearFormObject(),
				hour: "0",
				hour_end: "0",
				patials: [],
				partialRates:[],
				roomType: [],
				dayWeek: [],
				systemTime: [],
				ShiftSystem: [],
			};
		},
		methods: {
			validHour(event) {
				console.log("hour", this.hour);
				if (this.hour < 0 || this.hour > 23) {
					event.target.value = this.hour = 23;
					event.preventDefault();
				}
			},
			validMinute(event) {
				console.log("minte", this.minute);
				if (this.minute < 0 || this.minute >= 60) {
					event.target.value = this.minute = 59;
					event.preventDefault();
				}
			},
			formatSetHour() {
				return `${this.hour}:${this.minute}`;
			},
			formatSetHourEnd() {
				return `${this.hour_end}:${this.minute_end}`;
			},
			createPermission: function () {
				var url = "/tarifas/hour-templates/create";
				axios
					.post(url, this.form)
					.then((response) => {
						this.errors = [];
						this.form = this.getClearFormObject();
						$("#exampleModal").modal("hide");
						this.$emit("GetCreatedPermission");
					})
					.catch((error) => {});
			},
getPartialRate(){
				let url='/configuracion/partial-rates/get'
				axios
					.get(url)
					.then(res => {
						this.partialRates = res.data.data
					})
					
			},
			getClearFormObject() {
				return {
					room_type_id: "",
					hour: "00:00",
					hour_end: "00:00",
					rate: "",
					partial_rates_id: '',
					shift_system_id: "1",
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

			getShiftSystem() {
				var urlKeeps = "/configuracion/shift-system/get";
				axios
					.get(urlKeeps)
					.then((response) => {
						this.ShiftSystem = response.data.data;
					})
					.catch((err) => {});
			},
		},
	};
</script>
