<template>
	<ModalComponent idModal="showOcuppyRoom" title>
		<template #title>
			<h5>Ocupar Habitación</h5>
		</template>
		<div class="row">
			<label for="description" class="form-label">Cédula de Identidad</label>
			<div class="input-group mb-3">
				<input
					type="text"
					class="form-control"
					aria-describedby="button-addon2"
					name="description"
					v-model="form.document"
				/>
				<button
					class="btn btn-outline-secondary"
					type="button"
					@click="getClient"
					id="button-addon2"
				>
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="16"
						height="16"
						fill="currentColor"
						class="bi bi-search"
						viewBox="0 0 16 16"
					>
						<path
							d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"
						/>
					</svg>
				</button>
			</div>
			<input type="text" class="form-control" />
		</div>
		<label for="description" class="form-label">Descripción</label>
		<input
			type="text"
			name="description"
			v-model="form.description"
			class="form-control"
		/>
	</ModalComponent>
</template>
<script setup>
	import ModalComponent from "@/components/ModalComponent.vue";

	import { RoomStore } from "../RoomStore";
	import { HelperStore } from "@/HelperStore";
	import { ocuppyRoomStore } from "./OcuppyRoomStore";
	import { storeToRefs } from "pinia";

	const store = ocuppyRoomStore();
	const helper = HelperStore();

	const { getClient } = store;
	const { form } = storeToRefs(helper);
</script>
