<template>
	<CardComponent
		footer
		:bodyClass="['fs-6']"
		:titleClass="['text-center', 'fw-bold']"
		:footerClass="['text-center', 'fw-bold']"
		:footerStyle="footerStyle"
		@dblclick="updateItem"
	>
		<template #title>
			{{ item.attributes.name }}
			<br />
			{{
				`$${item.relationships.partialCost.attributes.rate} (${item.relationships.partialCost.relationships.partialRate.attributes.name})`
			}}
		</template>
		<template #body>
			<div class="mx-auto">
				<ButtonComponent
					:btnClass="['btn-info']"
					text="Ver Detalle"
					@click="room.showDetail(item)"
				/>
				<ButtonComponent
					:btnClass="['btn-info']"
					text="Ocupar"
					@click="room.showDetail(item)"
				/>
			</div>
			<br />
			<b>Tiempo Restante</b>
			<!-- <b>Precio - Parcial:</b> -->
			<!-- <br /> -->
			<b>Tipo Habitación:</b
			>{{ item.relationships.partialCost.relationships.roomType.attributes.name }}
		</template>
		<template #footer>
			{{ item.relationships.roomStatus.attributes.name }}
		</template>
	</CardComponent>
</template>

<script setup>
	import { ref, computed, toRefs } from "vue";
	import CardComponent from "@/components/CardComponent.vue";
	import { HelperStore } from "@/HelperStore";
	import { RoomStore } from "../RoomStore";
	import ButtonComponent from "@/components/ButtonComponent.vue";
	import ModalComponent from "@/components/ModalComponent.vue";
	const helper = HelperStore();
	const room = RoomStore();

	const updateItem = () => {
		if (helper.permiss.updated) {
			console.log(item);
			helper.ShowUpdatedModal(item.value, room.setForm);
		}
	};

	// props for the component
	const props = defineProps({
		item: {
			type: Object,
			required: true,
		},
		footerStyle: {
			type: Array,
			default: [],
		},
	});

	const { item } = toRefs(props);
	// const rate = pro.;
	// let part =
	// 	pro.item.relationships.partialCost.relationships.partialRate.attributes.name;
</script>

<style></style>
