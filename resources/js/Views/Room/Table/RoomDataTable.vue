<template>
	<div class="row justify-content-center">
		<!-- Breadcrumbs-->
		<!--	<ol class="breadcrumb">
	  <li class="breadcrumb-item">
	  <a href="#">Dashboard</a>
	  </li>
	  <li class="breadcrumb-item active">Habitaciones</li>
	  </ol>-->

		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header p-0">
				<div class="row justify-content-between">
					<div class="col-2 my-auto">
						<i class="fas fa-table"></i>
						<select
							class="mx-3"
							@change="getAllWithFilter"
							v-model="estate_type_id"
						>
							<option value="">Todo</option>
							<option
								v-for="(item, i) in useStore.estateTypes"
								:key="i"
								:value="item.id"
							>
								{{ item.attributes.name }}
							</option>
						</select>
					</div>
					<div
						class="text-right btn-group col"
						role="group"
						aria-label="Basic example"
					>
						<ButtonComponent
							:btnClass="['btn-light']"
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
						<ButtonComponent
							:btnClass="['btn-light']"
							@click="filterRoomsByStatus('culminar')"
							text="Por Culminar"
						/>
                        <ButtonComponent
							:btnClass="['btn-light']"
							@click="filterRoomsByStatus('terminado')"
							text="Culminado"
						/>
					</div>
					<div class="col-2">
						<a
							data-toggle="modal"
							v-on:click.prevent="ShowCreateModal()"
							v-if="permiss.create"
							class="btn btn-primary text-white btn-icon-split"
						>
							<i class="fas fa-check"></i>
							<span class="text font-montserrat font-weight-bold"
								>Crear Habitacion</span
							>
						</a>
					</div>
				</div>
			</div>
			<div class="card-body fondo">
				<div class="row">
					<RoomsGrid
						v-for="(item, i) in all"
						:key="i"
						:item="item"
						:footerStyle="[
							item.relationships.roomStatus.attributes.color.css ?? '',
						]"
						@dblclick="ShowUpdatedModal(item, useStore.setForm)"
					/>
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
	import { onMounted, ref } from "vue";
	import { ConfigurationStore } from "../../Configuration/ConfigurationStore";
	const config = ConfigurationStore();

	const useHelper = HelperStore();
	const useStore = RoomStore();

	const { permiss, all, item } = storeToRefs(useHelper);
	const { ShowCreateModal, ShowUpdatedModal, deleteItem } = useHelper;
	const { rooms, estate_type_id } = storeToRefs(useStore);
	const { filterRoomsByStatus } = useStore;

	const getAllWithFilter = () => {
		useStore.filterRoomsByEstateType(estate_type_id.value);
	};

	onMounted(() => {
        let op = useStore.login_option?? ''
        useHelper.getAll(`estate_type_id=${op}`);
		config.getConfiguration()
		useStore.getRoomStatus();
	});
</script>
<style>
	.global-scroll {
		height: 300px;
		overflow-y: scroll;
	}

	.fondo {
		/*background-image: url('/img/Logo.png');
	background-repe
	at: no-repeat;
	background-position: center;
	background-size: 20%;*/
	}
</style>
