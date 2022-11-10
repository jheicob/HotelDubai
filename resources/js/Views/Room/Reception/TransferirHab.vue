<template>
	<button
		v-if="store.updated_reception"
		class="btn btn-secondary text-white btn-icon-split col-2"
		type="button"
		@click="showModal"
	>
		Transferir
	</button>
	<ModalComponent idModal="transferir" title="">
		<template #title>
			<h3>Transferir Habitación</h3>
		</template>
		<div class="row">
			<div class="form-floating">
				<select
					class="form-select"
					id="room_object"
					aria-label="Floating label select example"
				>
					<option selected>Seleccione Habitación</option>
					<option v-for="(room, i) in rooms" :key="i" :value="room.id">
						{{ room.attributes?.name ?? "" }} -
						{{ room.relationships?.estateType.attributes.name ?? "" }}
						-
						{{
							room.relationships?.partialCost.relationships.roomType
								.attributes.name ?? ""
						}}
						-
						{{ room.relationships?.partialCost.attributes.rate ?? "" }}
						({{
							room.relationships?.partialCost.relationships.partialRate
								.attributes.name ?? ""
						}})
					</option>
				</select>
				<label for="room_object" class="mx-3">Habitación Objetivo</label>
			</div>
			<div class="form-floating">
				<textarea
					class="form-control my-4"
					placeholder="Introduzca un motivo ..."
					id="motive"
					v-model="motive"
				></textarea>
				<label for="motive" class="mx-3">Motivo</label>
			</div>
		</div>
		<div class="row">
			<div class="col-2 mx-auto">
				<div class="form-floating">
					<select
						class="form-select"
						id="room_object"
						aria-label="Floating label select example"
					>
						<option selected value="Inconformidad">Inconformidad</option>
						<option value="Reparación">Reparación</option>
					</select>
					<label for="room_object" class="mx-3">Tipo</label>
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<button
				type="button"
				class="btn btn-primary col-3 mx-auto"
				@click="transferir"
			>
				Transferir
			</button>
		</div>
	</ModalComponent>
</template>

<script setup>
	import ModalComponent from "@/components/ModalComponent.vue";
	import { receptionStore } from "./ReceptionStore.js";
	import { HelperStore } from "@/HelperStore";
	import { RoomStore } from "../RoomStore";
	import { onMounted, ref } from "vue";

	const store = receptionStore();
	const helper = HelperStore();
	const room = RoomStore();
	const rooms = ref([]);

	defineProps({
		room_id: Number,
	});

	const motive = ref("");
	const transferir = () => {
		axios
			.post("room/transfer-reception", {
				room_id,
				motive,
			})
			.then(resp);
	};
	const showModal = () => {
		$("#transferir").modal("show");
	};

	const getRooms = () => {
		axios.get("/room/get?room_status_id=2").then((res) => {
			rooms.value = res.data.data;
		});
	};
	onMounted(() => {
		getRooms();
	});
</script>

<style></style>
