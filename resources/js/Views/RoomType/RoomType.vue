<template>
	<div class="row justify-content-center">
		<div class="col-md-12">
			asd
			<permissions-data-table
				:create="create"
				:deletet="deletet"
				:updated="updated"
			/>
		</div>
	</div>
</template>

<script setup>
	import PermissionsDataTable from "./Table/RoomTypeDataTable.vue";
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
	});

	useHelper.permiss = props;
</script>
