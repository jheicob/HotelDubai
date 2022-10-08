<template>
	<div class="row justify-content-center">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Perfil</li>
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
				Datos De Perfil
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<h2 class="text-center">Datos Basicos</h2>
						<form class="row g-3">
							<div class="col-md-6">
								<label for="inputEmail4" class="form-label">Nombre</label>
								<input
									v-model="form.name"
									type="text"
									class="form-control"
								/>
							</div>
							<div class="col-md-6">
								<label for="inputPassword4" class="form-label"
									>Email</label
								>
								<input
									v-model="form.email"
									type="email"
									class="form-control"
								/>
							</div>

							<div class="col-12 text-center">
								<button
									v-on:click.prevent="updateProfile()"
									type="submit"
									class="btn btn-primary"
								>
									Guardar
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import axios from "axios";
	import toastr from "toastr";

	export default {
		name: "Profile",
		components: {},
		created() {
			this.getKeeps();
		},
		data() {
			return {
				form: {
					email: "",
					name: "",
				},
			};
		},
		methods: {
			getKeeps: function () {
				var urlKeeps = "/profile/get";
				axios
					.get(urlKeeps)
					.then((response) => {
						this.form.email = response.data.data.attributes.email;
						this.form.name = response.data.data.attributes.name;
					})
					.catch((err) => {});
			},

			updateProfile: function () {
				var url = "/profile/update";
				axios
					.put(url, this.form)
					.then((response) => {
						this.errors = [];
						toastr.success("Usuario actualizado");
					})
					.catch((error) => {
						if (error.response.status == 422) {
							this.errors = error.response.data.errors;
						}
						for (error in this.errors) {
							toastr.error(this.errors[error]);
						}
					});
			},
		},
	};
</script>
<style src="toastr/build/toastr.css"></style>
