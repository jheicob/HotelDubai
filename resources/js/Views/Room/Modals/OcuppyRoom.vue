<template>
	<ModalComponent idModal="showOcuppyRoom" title>
		<template #title>
			<h5>Ocupar Habitación</h5>
		</template>
		<p>Voy a ocupar un habitación</p>
	</ModalComponent>
</template>
<script setup>
	import ModalComponent from "@/components/ModalComponent.vue";

	import { RoomStore } from "../RoomStore";
	import { HelperStore } from "@/HelperStore";
</script>
