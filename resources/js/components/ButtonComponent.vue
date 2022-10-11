<template>
	<button type="button" class="btn" :class="btnClass" :disabled="disabled">
		<slot>{{ text }}</slot>
	</button>
</template>
<script setup>
	import { ref, toRefs } from "vue";
	const props = defineProps({
		text: {
			type: String,
			default: "Button",
		},
		btnClass: {
			type: Array,
			default: "btn-primary",
		},
		disabled: {
			type: Boolean,
			default: false,
		},
	});
</script>
