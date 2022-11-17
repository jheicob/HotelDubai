<template>
	<div class="row justify-content-center">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Tipos Habitacion</li>
		</ol>

		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
				Data Tipos Habitacion
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<div class="col text-right">
						<a
							data-toggle="modal"
							v-on:click.prevent="useStore.ShowCreateModal()"
							v-if="useHelper.permiss.create"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<i class="fas fa-check"></i>
							<span class="text font-montserrat font-weight-bold"
								>Crear Tipo Habitacion</span
							>
						</a>
					</div>
					<table
						class="table table-bordered"
						id="dataTable"
						width="100%"
						cellspacing="0"
					>
						<thead>
							<tr>
								<th>ID</th>
								<th>Tarifa</th>
								<th>Accion</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Tarifa</th>
								<th>Accion</th>
							</tr>
						</tfoot>
						<tbody>
							<tr v-for="keep in useStore.all" :key="keep.id">
								<td>{{ keep.id }}</td>
								<td>{{ keep.attributes.name }}</td>
								<td>{{ keep.attributes.rate }}</td>
								<td>
									<i
										v-on:click.prevent="
											useStore.ShowUpdateModel(keep)
										"
										v-if="useHelper.permiss.updated"
										class="ico fas fa-edit fa-lg text-secondary"
										style="cursor: pointer"
										title="Borrar"
									></i>

									<i
										v-on:click.prevent="useStore.deleteRoomType(keep)"
										v-if="useHelper.permiss.deletet"
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
				</div>
			</div>
		</div>
		<CreatePermission />
		<UpdatePermission />
	</div>
</template>

<script setup>
	// this composition component vue 3
	import { onMounted } from "vue";
	import CreatePermission from "../Modals/CreateExtraGuest.vue";
	import UpdatePermission from "../Modals/UpdateExtraGuest.vue";

	//import store of component
	import { ExtraGuestStore } from "../ExtraGuestStore";

	// import helperStore
	import { HelperStore } from "@/HelperStore";

	const useHelper = HelperStore();
	const useStore = ExtraGuestStore();

	onMounted(() => {
		useStore.getRoomTypes();
	});
</script>
