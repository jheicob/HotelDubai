<template>
	<div class="row justify-content-center">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Habitaciones</li>
		</ol>

		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
				Data Habitaciones
			</div>
			<div class="card-body">
				<div>
					<div class="col text-right">
						<a
							data-toggle="modal"
							v-on:click.prevent="ShowCreateModal()"
							v-if="permiss.create"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<i class="fas fa-check"></i>
							<span class="text font-montserrat font-weight-bold"
								>Crear Habitacion</span
							>
						</a>
					</div>
					<div class="mb-2">
						<ButtonComponent
							:btnClass="['btn-primary', 'mx-1']"
							v-for="(status, i) in useStore.roomStatus"
							:key="i"
							:text="status.attributes.name"
						/>
					</div>

					<div class="row">
						<div class="col-3" v-for="(item, i) in all" :key="i">
							<RoomsGrid :item="item" />
						</div>
					</div>

					<!-- <table
						class="table table-bordered"
						id="dataTable"
						width="100%"
						cellspacing="0"
					>
						<thead>
							<tr>
								<th>ID</th>
								<th>N° Habitación</th>
								<th>Descripción</th>
								<th>Tarifa</th>
								<th>Parcial Mínimo</th>
								<th>Tipo de Habitación</th>
								<th>Estado</th>
								<th>Accion</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>ID</th>
								<th>N° Habitación</th>
								<th>Descripción</th>
								<th>Tarifa</th>
								<th>Parcial Mínimo</th>
								<th>Tipo de Habitación</th>
								<th>Estado</th>
								<th>Accion</th>
							</tr>
						</tfoot>
						<tbody>
							<tr v-for="keep in all" :key="keep.id">
								<td>{{ keep.id }}</td>
								<td>
									{{ keep.attributes.name }}
								</td>
								<td>
									{{ keep.attributes.description }}
								</td>
								<td>
									{{ keep.relationships.partialCost.attributes.rate }}
								</td>
								<td>
									{{
										keep.relationships.partialCost.relationships
											.partialRate.attributes.name
									}}
								</td>

								<td>
									{{
										keep.relationships.partialCost.relationships
											.roomType.attributes.name
									}}
								</td>
								<td>
									{{ keep.relationships.roomStatus.attributes.name }}
								</td>
								<td>
									<i
										@click="
											useHelper.ShowUpdatedModal(
												keep,
												useStore.setForm
											)
										"
										v-if="permiss.updated"
										class="ico fas fa-edit fa-lg text-secondary"
										style="cursor: pointer"
										title="Borrar"
									></i>

									<i
										v-on:click.prevent="deleteItem(keep)"
										v-if="permiss.deletet"
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
					</table> -->
				</div>
			</div>
		</div>
		<create-permission />
		<update-permission />
	</div>
</template>

<script setup>
	import CreatePermission from "../Modals/CreateRoom.vue";
	import UpdatePermission from "../Modals/UpdateRoom.vue";
	import { HelperStore } from "@/HelperStore";
	import ButtonComponent from "@/components/ButtonComponent.vue";
	import RoomsGrid from "./RoomsGrid.vue";
	import { RoomStore } from "../RoomStore";
	import { storeToRefs } from "pinia";
	import { onMounted } from "vue";
	const useHelper = HelperStore();
	const useStore = RoomStore();

	const { permiss, all } = storeToRefs(useHelper);
	const { ShowCreateModal, ShowUpdateModal, deleteItem } = useHelper;

	onMounted(() => {
		useHelper.getAll();
		useStore.getRoomStatus();
	});
</script>
<style lang="scss">
	// @import "~bootstrap/scss/bootstrap";
</style>
