<template>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<users-data-table />
		</div>
	</div>
</template>

<script setup>
	import UsersDataTable from "./Table/UsersDataTable.vue";
	import { UserStore } from "./UserStore";
	import { RoleStore } from "./../Roles/RoleStore";
	import { onMounted } from "vue";

	const role_store = RoleStore();
	onMounted(() => {
		role_store.getRoles();
	});
	const props = defineProps({
		create: {
			type: String,
			default: 0,
		},
		deletet: {
			type: String,
			default: 0,
		},
		updated: {
			type: String,
			default: 0,
		},
	});

	const store = UserStore();

	store.permiss.create = props.create;
	store.permiss.deletet = props.deletet;
	store.permiss.updated = props.updated;
</script>
