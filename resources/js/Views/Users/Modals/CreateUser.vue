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
							Crear Usuario
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
							type="text"
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
							:multiple="true"
							label="name"
							track-by="id"
						>
						</multiselect>

                        <label for="name" class="form-label">Maquina Fiscal</label>
						<select v-model="store.form.fiscal_machine_id" class="form-select">
                            <option v-for="item in store.fiscalMachines"
                                :key="item.id"
                                :value="item.id"
                                >
                                {{item.attributes.name}}
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
						<button
							v-on:click.prevent="store.createUser()"
							:disabled="HelperStore().desactiveButton"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<span class="text font-montserrat font-weight-bold"
								>Crear Usaurio</span
							>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>

<script setup>
	import toastr from "toastr";
	import Multiselect from "vue-multiselect";
	import { UserStore } from "./../UserStore";
	import { RoleStore } from "./../../Roles/RoleStore";
	import { onMounted } from "vue";
	import { HelperStore } from "./../../../HelperStore";
	const store = UserStore();
	const role_store = RoleStore();
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style src="toastr/build/toastr.css"></style>
