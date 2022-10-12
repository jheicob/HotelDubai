<template>
	<ModalComponent idModal="showOcuppyRoom" title footer>
		<template #title>
			<h5>Ocupar Habitación</h5>
		</template>
		<label for="description" class="form-label">Documento de Identidad</label>
		<div class="input-group mb-3">
			<select v-model="form.type_document_id" class="form-select">
				<option value="">Seleccione...</option>
				<option
					v-for="document in type_documents"
					:key="document.id"
					:value="document.id"
				>
					{{ document.attributes.name }}
				</option>
			</select>
			<input
				type="text"
				class="form-control"
				aria-describedby="button-addon2"
				name="description"
				v-model="form.document"
				@blur="getClient"
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
		<div class="row">
			<div class="col">
				<label for="description" class="form-label">Nombre</label>
				<input
					type="text"
					name="description"
					v-model="form.first_name"
					:disabled="!client_exist"
					class="form-control"
				/>
			</div>
			<div class="col">
				<label for="description" class="form-label">Apellidos</label>
				<input
					type="text"
					name="description"
					v-model="form.last_name"
					:disabled="!client_exist"
					class="form-control"
				/>
			</div>
		</div>
		<label for="description" class="form-label">phone</label>
		<input
			type="text"
			name="description"
			v-model="form.phone"
			:disabled="!client_exist"
			class="form-control"
		/>
		<label for="description" class="form-label">email</label>
		<div class="input-group mb-3">
			<span class="input-group-text" id="basic-addon1">@</span>
			<input
				type="email"
				name="description"
				v-model="form.email"
				:disabled="!client_exist"
				class="form-control"
			/>
		</div>
		<hr />
		<div class="row">
			<div class="col">
				<label class="form-label">Fecha de Entrada</label>
				<input
					v-model="date"
					type="date"
					class="form-control"
					:disabled="!client_exist"
				/>
			</div>
			<div class="col">
				<label class="form-label">Hora de Entrada</label>
				<input
					v-model="hour"
					type="time"
					class="form-control"
					:disabled="!client_exist"
				/>
			</div>
		</div>
		<div>
			<label class="form-label">Cantidad de parciales</label>
			<input
				v-model="form.quantity_partial"
				type="number"
				class="form-control"
				:disabled="!client_exist"
			/>
			<div class="row">
				<div id="emailHelp" class="form-text col">
					Parcial mínimo:
					{{
						item.relationships?.partialCost.relationships.partialRate
							.attributes.name ?? ""
					}}
				</div>
				<div id="emailHelp" class="form-text col">
					Tarifa: $
					{{ item.relationships?.partialCost.attributes.rate ?? "" }}
				</div>
			</div>
		</div>
		<div>
			<label class="form-label">Observaciones</label>
			<input
				v-model="form.observation"
				type="text"
				class="form-control"
				:disabled="!client_exist"
			/>
		</div>

		<template #footer>
			<a class="btn btn-danger text-white btn-icon-split mb-4" data-dismiss="modal">
				<span class="text font-montserrat font-weight-bold">Cancelar</span>
			</a>
			<button
				:disabled="desactiveButton"
				v-on:click.prevent="storeAssignedRoom()"
				class="btn btn-primary text-white btn-icon-split mb-4"
			>
				<span class="text font-montserrat font-weight-bold"
					>Asignar Habitación</span
				>
			</button>
		</template>
	</ModalComponent>
</template>
<script setup>
	import ModalComponent from "@/components/ModalComponent.vue";

	import { RoomStore } from "../RoomStore";
	import { HelperStore } from "@/HelperStore";
	import { ocuppyRoomStore } from "./OcuppyRoomStore";
	import { storeToRefs } from "pinia";
	import { onMounted } from "vue";

	const store = ocuppyRoomStore();
	const helper = HelperStore();

	const { getClient, storeAssignedRoom } = store;

	const { form, item, desactiveButton } = storeToRefs(helper);
	const { client_exist, type_documents, date, hour } = storeToRefs(store);

	onMounted(() => {
		store.getTypeDocuments();
	});
</script>
