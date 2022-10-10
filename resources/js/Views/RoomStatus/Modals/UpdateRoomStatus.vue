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
							Modificar Estado Habitacion
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
						<label for="name" class="form-label">Nombre</label>

						<input
							type="name"
							id="name"
							class="form-control form-control-user mb-3"
							autofocus
							name="name"
							v-model="form.name"
						/>

						<label for="name" class="form-label">Descripcion</label>

						<input
							type="name"
							id="name"
							class="form-control form-control-user mb-3"
							autofocus
							name="name"
							v-model="form.description"
						/>
						<label form="color" class="form-label">Color</label>
						<ColorPicker mode="solid" @colorChanged="getColor" />
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
							:disabled="btnDisabled"
							v-on:click.prevent="createPermission()"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<span class="text font-montserrat font-weight-bold"
								>Modificar Estado Habitacion</span
							>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>

<script>
	import axios from "axios";
	import ColorPicker from "@mcistudio/vue-colorpicker";

	export default {
		name: "RoomTypeUpdate",
		components: {
			ColorPicker,
		},

		created() {},
		data() {
			return {
				form: this.getClearFormObject(),
				btnDisabled: false,
			};
		},
		methods: {
			createPermission: function () {
				this.btnDisabled = true;

				var url = "/configuracion/room-status/" + this.form.id;
				axios
					.put(url, this.form)
					.then((response) => {
						this.errors = [];
						this.getClearFormObject();
						$("#exampleModal2").modal("hide");
						this.$emit("GetCreatedPermission");
					})
					.catch((error) => {})
					.finally(() => (this.btnDisabled = false));
			},
			UpdateGetPermission(permission) {
				this.form.name = permission.attributes.name;
				this.form.description = permission.attributes.description;
				this.form.color = permission.attributes.color;
				this.form.id = permission.id;
			},
			getClearFormObject() {
				return {
					id: null,
					name: null,
					description: null,
					color: null,
				};
			},
			getColor(color) {
				console.log(color);
				this.form.color = color;
			},
		},
	};
</script>
