<template>
	<div class="row justify-content-center">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Usuarios</li>
		</ol>

		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
				Data Usuarios
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<div class="col text-right">
						<a
							data-toggle="modal"
							v-on:click.prevent="store.OpenCreateUser()"
							v-if="create"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<i class="fas fa-check"></i>
							<span class="text font-montserrat font-weight-bold"
								>Crear Usuario</span
							>
						</a>
					</div>
					<table class="table table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Email</th>
								<th>Rol</th>
								<th>Accion</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Email</th>
								<th>Rol</th>
								<th>Accion</th>
							</tr>
						</tfoot>
						<tbody>
							<tr v-for="keep in store.keeps" :key="keep.id">
								<td>{{ keep.id }}</td>
								<td>{{ keep.attributes.name }}</td>
								<td>{{ keep.attributes.email }}</td>
								<td>
									<span
										v-for="role in keep.relationships.roles"
										:key="role.id"
									>
										{{ role.attributes.name }}
									</span>
								</td>
								<td>
									<i
										v-on:click.prevent="store.UpdatedUser(keep)"
										v-if="updated && !keep.attributes.deleted_at"
										class="ico fas fa-edit fa-lg text-secondary"
										style="cursor: pointer"
										title="Borrar"
									></i>

									<i
										v-on:click.prevent="store.deletePermission(keep)"
										v-if="deletet"
										:class="
											keep.attributes.deleted_at
												? 'ico fas fa-trash-restore-alt fa-lg text-secondary'
												: 'ico fas fa-trash fa-lg text-secondary'
										"
										style="cursor: pointer"
										title="Borrar"
									></i>
								</td>
							</tr>
						</tbody>
					</table>
					<Pagination
						align="center"
						:data="pagination"
						@pagination-change-page="store.getKeeps"
					/>
				</div>
			</div>
		</div>
		<create-user ref="componentecreate" />
		<update-user ref="componente" />
	</div>
</template>

<script setup>
	import CreateUser from "../Modals/CreateUser.vue";
	import UpdateUser from "../Modals/UpdateUser.vue";
	import Pagination from "laravel-vue-pagination";
	import { UserStore } from "./../UserStore";
	import { onMounted } from "vue";

	const store = UserStore();

	const create = store.permiss.create;
	const updated = store.permiss.updated;
	const deletet = store.permiss.deletet;
	const pagination = store.pagination;
	onMounted(() => {
		store.getKeeps();
	});
</script>

<style>
	@import "~sweetalert2/dist/sweetalert2.css";
</style>
