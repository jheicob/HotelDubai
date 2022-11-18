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
							Modificar Usuario
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
							v-model="store.form.name"
						/>

						<label for="name" class="form-label">Email</label>
						<input
							type="text"
							id="email"
							class="form-control form-control-user mb-3"
							autofocus
							name="email"
							v-model="store.form.email"
						/>

						<label for="name" class="form-label">Contraseña</label>
						<input
							type="password"
							id="password"
							class="form-control form-control-user mb-3"
							autofocus
							name="password"
							v-model="store.form.password"
						/>

						<label for="checkedPermissions" class="form-label">Roles</label>
						<multiselect
							v-model="store.form.role_id"
							id="checkedPermissions"
							:options="role_store.roles"
							label="name"
							track-by="id"
						>
						</multiselect>
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
							v-on:click.prevent="store.putUser()"
							:disabled="HelperStore().desactiveButton"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<span class="text font-montserrat font-weight-bold"
								>Modificar Rol</span
							>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>

<script setup>
	import { UserStore } from "./../UserStore";
	import Multiselect from "vue-multiselect";

	import { RoleStore } from "./../../Roles/RoleStore";
	import { onMounted } from "vue";
	import { HelperStore } from "./../../../HelperStore";
	const store = UserStore();
	const role_store = RoleStore();
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style src="toastr/build/toastr.css"></style>
