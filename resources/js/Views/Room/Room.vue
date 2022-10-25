<template>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<permissions-data-table v-show="!reception.show" />
			<CreateReception v-show="reception.show" v-if="props.ocuppy" />
			<GenerateInvoice />
		</div>
	</div>
</template>

<script setup>
	import PermissionsDataTable from "./Table/RoomDataTable.vue";
	import { HelperStore } from "@/HelperStore";
	import { onMounted } from "vue";
	import { receptionStore } from "./Reception/ReceptionStore.js";
	import CreateReception from "./Reception/CreateReception.vue";
	const useHelper = HelperStore();
	const reception = receptionStore();

	onMounted(() => {});
	const props = defineProps({
		create: {
			type: Boolean,
			default: false,
		},
		deletet: {
			type: Boolean,
			default: false,
		},
		updated: {
			type: Boolean,
			default: false,
		},
		ocuppy: {
			type: Boolean,
			default: false,
		},
		free: {
			type: Boolean,
			default: false,
		},
		extend: {
			type: Boolean,
			default: false,
		},
		clean: {
			type: Boolean,
			default: false,
		},
	});

useHelper.permiss = props
</script>
