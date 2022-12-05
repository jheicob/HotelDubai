<template>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<permissions-data-table v-show="!reception.show" />
			<CreateReception v-show="reception.show" v-if="props.ocuppy" />

		</div>
	</div>
</template>

<script setup>
	import PermissionsDataTable from "./Table/RoomDataTable.vue";
	import { HelperStore } from "@/HelperStore";
	import { onMounted } from "vue";
	import { receptionStore } from "./Reception/ReceptionStore.js";
	import CreateReception from "./Reception/CreateReception.vue";
    import { storeToRefs } from "pinia";
    import { RoomStore } from "./RoomStore";
	const useHelper = HelperStore();
	const reception = receptionStore();

    const {login_option,estate_type_id} = storeToRefs(RoomStore())
	onMounted(() => {

	});
	const props = defineProps({
		role: {
			type: String,
			default: "",
		},
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
		change_parcial: {
			type: Boolean,
			default: false,
		},
		in_repair: {
			type: Boolean,
			default: false,
		},
		repair: {
			type: Boolean,
			default: false,
		},
        estate_type_id: {
            type: String,
            default: "",
        },
        in_view_rooms: {
            type: Boolean,
            default: false,
            },
        fiscal_machine_id:{
            type: String,
            default: "",
        }
	});
    login_option.value = estate_type_id.value = props.estate_type_id
	useHelper.permiss = props;
</script>
