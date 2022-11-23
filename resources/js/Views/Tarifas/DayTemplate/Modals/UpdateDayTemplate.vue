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
							Modificar Plantilla de Hora
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

						<label for="hour" class="form-label">Día</label>
						<select
							class="form-select"
							aria-label="Default select example"
							v-model="form.day_week_id"
						>
							<option selected value="">Seleccione Día</option>
							<option
								v-for="keep in dayWeek"
								:key="keep.id"
								:value="keep.id"
							>
								{{ keep.attributes.name }}
							</option>
						</select>
                        <div class="row">
                            <div class="col">
                                <label for="rate" class="form-label">Hora de Inicio</label>
                                <input
                                    class="form-control"
                                    name="rate"
                                    type="time"
                                    v-model="form.hour_start"
                                />
                            </div>
                            <div class="col">
                                <label for="rate" class="form-label">Hora de Fin</label>
                                <input
                                    class="form-control"
                                    name="rate"
                                    type="time"
                                    v-model="form.hour_end"
                                />
                            </div>
                        </div>
						<label for="rate" class="form-label">Tarifa</label>
						<input
							class="form-control"
							name="rate"
							type="number"
							v-model="form.rate"
						/>
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
								>Modificar Plantilla de Hora</span
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
		name: "UpdateHourTemplate",
		components: {},

		created() {},
		data() {
			return {
				form: this.getClearFormObject(),
				hour: "0",
				minute: "0",
				patials: [],
				roomType: [],
				dayWeek: [],
				systemTime: [],
				ShiftSystem: [],
			};
		},
		methods: {
			createPermission: function () {
				var url = "/tarifas/day-templates/" + this.form.id;
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
			UpdateGetPermission(permission) {
				this.form.id = permission.id;
				this.form.room_type_id = permission.relationships.roomType.id;
				this.form.day_week_id = permission.relationships.dayWeek.id;
				this.form.rate = permission.attributes.rate;
				this.form.hour_start = permission.attributes.hour_start;
				this.form.hour_end = permission.attributes.hour_end;
				this.getRoomType();
				this.getDayWeek();
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

			getDayWeek() {
				var urlKeeps = "/configuracion/day-week/get";
				axios
					.get(urlKeeps)
					.then((response) => {
						this.dayWeek = response.data.data;
					})
					.catch((err) => {});
			},
			getClearFormObject() {
				return {
					room_type_id: "",
					day_week_id: "",
					rate: "",
                    hour_end: '',
                    hour_start: '',
				};
			},
		},
	};
</script>
