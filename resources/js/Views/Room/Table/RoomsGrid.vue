<template>
	<CardComponent
		footer
		:bodyClass="['fs-6']"
		:titleClass="['text-center', 'fw-bold']"
		:footerClass="['text-center', 'fw-bold', 'text-white']"
		:footerStyle="footerStyle"
		:cardStyle="[]"
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
			<div class="text-center">
				<ButtonComponent
					:btnClass="['btn-info', 'mx-1']"
					text="Ver Detalle"
					@click="room.showDetail(item)"
				/>
				<ButtonComponent
					v-if="room.ShowOcuppyButton(item)"
					:btnClass="['btn-info']"
					text="Ocupar"
					@click="room.ShowOccuppyModal(item)"
				/>
				<ButtonComponent
					v-if="room.ShowFreeButton(item)"
					:btnClass="['btn-info']"
					text="Liberar"
					@click="room.showDetail(item)"
				/>
				<ButtonComponent
					v-if="room.ShowExtendButton(item)"
					:btnClass="['btn-info', 'mt-2']"
					text="Extender"
					@click="room.showDetail(item)"
				/>
			</div>
			<div v-if="item.relationships.roomStatus.attributes.name == 'Ocupado'">
				<br />
				<b>Tiempo Restante</b>
			</div>

			<!-- <b>Precio - Parcial:</b> -->
			<!-- <br /> -->
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
