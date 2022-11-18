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
					v-model="form.room_destiny"
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
					v-model="form.observation"
				></textarea>
				<label for="motive" class="mx-3">Motivo</label>
			</div>
		</div>
		<div class="row">
			<div class="col-6 mx-auto">
				<div class="form-floating">
					<select
						class="form-select"
						id="room_object"
						v-model="form.motive"
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
	const form = ref({
		room_origin: "",
		room_destiny: "",
		motive: "Inconformidad",
		observation: "",
	});
	const props = defineProps({
		room_id: Number,
	});

	const motive = ref("");
	const transferir = () => {
		form.value.room_origin = props.room_id
			axios.post("client/transfer-room", form.value).then((resp) => {
				$("#transferir").modal("hide");

				let ventana = window
					.open("/client/reception-ticket?room_id=" + form.value.room_destiny)
					.print();
				form.value = {
					room_origin: "",
					room_destiny: "",
					motive: "Inconformidad",
					observation: "",
				};

				location.reload();
			});
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
