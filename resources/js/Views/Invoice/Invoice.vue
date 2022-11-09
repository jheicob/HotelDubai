<template>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<permissions-data-table />
		</div>
	</div>
</template>

<script setup>
	import PermissionsDataTable from "./Table/InvoiceDataTable.vue";
	import { HelperStore } from "../../HelperStore";

	const useHelper = HelperStore();

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
		cancel: {
			type: Boolean,
			default: false,
		},
		report_x: {
			type: Boolean,
			default: false,
		},
		report_z: {
			type: Boolean,
			default: false,
		},
	});

	useHelper.permiss = props;
</script>
