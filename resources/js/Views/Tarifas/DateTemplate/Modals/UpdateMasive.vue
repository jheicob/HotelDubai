<template>
    <ButtomComponent @click.prevent="openModal">
        Actualizar Masivo
    </ButtomComponent>
	<form>
		<!-- Modal -->
		<div
			class="modal fade"
			id="updateMasive"
			tabindex="-1"
			role="dialog"
			aria-labelledby="updateMasive"
			aria-hidden="true"
		>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header py-2">
						<h5
							class="modal-title title-page text-secondary"
							id="exampleModalLabel"
						>
							Actualización Masiva
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
						<label for="name" class="form-label">Plantillas de Rango</label>
                        <multiselect
							v-model="form.room_type_id"
							id="checkedPermissions"
							:options="setItems"
							:multiple="true"
							label="name"
							track-by="id"
						>
						</multiselect>

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
								>Actualizar plantillas</span
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
    import ButtomComponent from "@/components/ButtonComponent"
    import toastr from "toastr";
    import "toastr/build/toastr.css";
	export default {
		name: "updateMasive",
		components: {
            Multiselect,
            ButtomComponent
        },
        props:{
            items: {
                type: Array,
                required: true
            }
        },

		created() {
			this.getRoomType();
			this.getDayWeek();
		},
        computed:{
            setItems(){
                return this.items.map((item) =>({
                    name: `${item.relationships.roomType.attributes.name} - ${item.attributes.hour_start} - ${item.attributes.hour_end}  (${item.relationships.partialRate.attributes.name}-${item.attributes.rate})`,
                    id: item.id,
                }));
            },
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
                errors: [],
				ShiftSystem: [],
			};
		},
		methods: {
            openModal(){
                $('#updateMasive').modal('show')
            },
            setFields(field){
                return field.map(item=>(item.id))
            },
            getErrorRequest(err){
                if (err.response?.status == 422) {
                    this.errors = err.response.data.data.errors;
                } else {
                    this.errors = err;
                }
                for (let error in this.errors) {
                    toastr.error(this.errors[error]);
                }
            },
			createPermission: function () {
				var url = "/tarifas/date-templates/masive-update";
                this.form.day_template_id = this.setFields(this.form.room_type_id)
				axios
					.put(url, this.form)
					.then((response) => {
						this.errors = [];
						this.form = this.getClearFormObject();
						$("#updateMasive").modal("hide");
						this.$emit("GetCreatedPermission");
					})
					.catch((error) => this.getErrorRequest(error));
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
