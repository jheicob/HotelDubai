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
							Crear plantilla de Días
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
                        <multiselect
							v-model="form.room_type_id"
							id="checkedPermissions"
							:options="setRoomTypes"
							:multiple="true"
							label="name"
							track-by="id"
						>
						</multiselect>


						<label for="hour" class="form-label">Día</label>
                        <multiselect
							v-model="form.day_week_id"
							id="checkedPermissions"
							:options="setDayWeeks"
							:multiple="true"
							label="name"
							track-by="id"
						>
						</multiselect>

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
								>Crear plantilla de Día</span
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
	import Multiselect from "vue-multiselect";

	export default {
		name: "PartialCostCreate",
		components: {
            Multiselect,
        },

		created() {
			this.getRoomType();
			this.getDayWeek();
		},
        computed:{
            setRoomTypes() {
                return this.roomType.map(item =>({
                    name:item.attributes.name,
                    id: item.id
                }))
            },
            setDayWeeks(){
                return this.dayWeek.map(item =>({
                    name:item.attributes.name,
                    id: item.id
                }))
            }
        },
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
            setFields(field){
                return field.map(item=>(item.id))
            },
			createPermission: function () {
				var url = "/tarifas/day-templates/create";
                this.form.day_week_id = this.setFields(this.form.day_week_id)
                this.form.room_type_id = this.setFields(this.form.room_type_id)
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
			getClearFormObject() {
				return {
                    hour_end: '',
                    hour_start: '',
					room_type_id: "",
					day_week_id: "",
					rate: "",
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

			getDayWeek() {
				var urlKeeps = "/configuracion/day-week/get";
				axios
					.get(urlKeeps)
					.then((response) => {
						this.dayWeek = response.data.data;
					})
					.catch((err) => {});
			},
		},
	};
</script>
