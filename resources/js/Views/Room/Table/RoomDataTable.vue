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
					<div class="mb-2 row">
						<div class="col-5"></div>
						<div
							class="mb-2 text-right btn-group col"
							role="group"
							aria-label="Basic example"
						>
							<ButtonComponent
								:btnClass="['btn-light']"
								:key="i"
								@click="filterRoomsByStatus()"
								text="Todo"
							/>
							<ButtonComponent
								:btnClass="['btn-light', 'fw-bold']"
								v-for="(status, i) in useStore.roomStatus"
								:key="i"
								@click="filterRoomsByStatus(status.id)"
							>
								<span
									:style="[
										status.attributes.color.color
											? 'color:rgb(' +
											  status.attributes.color.color.r +
											  ',' +
											  status.attributes.color.color.g +
											  ',' +
											  status.attributes.color.color.b +
											  ')'
											: '',
									]"
									>{{ status.attributes.name }}</span
								>
							</ButtonComponent>
						</div>
					</div>

					<div class="row">
						<div class="col-3 mt-2" v-for="(item, i) in all" :key="i">
							<RoomsGrid
								:item="item"
								:footerStyle="[
									item.relationships.roomStatus.attributes.color.css ??
										'',
								]"
							/>
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
		<ModalComponent idModal="showDetail" title>
			<template #title>
				<h5>Detalle de Habitación</h5>
			</template>
			<p><b>Descripción:</b>{{ useHelper.item.attributes?.description ?? "" }}</p>
			<p>
				<b>Tipo de Habitación:</b
				>{{
					useHelper.item.relationships?.partialCost.relationships.roomType
						.attributes.name ?? ""
				}}
			</p>
		</ModalComponent>

		<OcuppyRoom />
	</div>
</template>

<script setup>
	import CreatePermission from "../Modals/CreateRoom.vue";
	import UpdatePermission from "../Modals/UpdateRoom.vue";
	import { HelperStore } from "@/HelperStore";
	import OcuppyRoom from "../Modals/OcuppyRoom.vue";
	import ModalComponent from "@/components/ModalComponent.vue";
	import ButtonComponent from "@/components/ButtonComponent.vue";
	import RoomsGrid from "./RoomsGrid.vue";
	import { RoomStore } from "../RoomStore";
	import { storeToRefs } from "pinia";
	import { onMounted } from "vue";
	const useHelper = HelperStore();
	const useStore = RoomStore();

	const { permiss, all, item } = storeToRefs(useHelper);
	const { ShowCreateModal, ShowUpdateModal, deleteItem } = useHelper;
	const { rooms } = storeToRefs(useStore);
	const { filterRoomsByStatus } = useStore;

	onMounted(() => {
		useHelper.getAll();
		useStore.getRoomStatus();
	});
</script>
<style>
	.global-scroll {
		height: 300px;
		overflow-y: scroll;
	}
</style>
