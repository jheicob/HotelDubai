<template>
	<div class="card mb-3" :style="style" :class="cardClass">
		<div class="card-header" :class="titleClass">
			<slot name="title">Titulo</slot>
		</div>
		<div class="card-body" :class="bodyClass">
			<slot name="body"> Body</slot>
		</div>
		<div class="card-footer" v-if="footer" :class="footerClass">
			<slot name="footer" />
		</div>
	</div>
</template>
<script setup>
	// props for the component
	const props = defineProps({
		cardClass: {
			type: Array,
		},
		style: {
			type: String,
			default: "max-width: 18rem",
		},
		footer: {
			type: Boolean,
			default: false,
		},
		titleClass: {
			type: Array,
			default: [],
		},
		bodyClass: {
			type: Array,
			default: [],
		},
		footerClass: {
			type: Array,
			default: [],
		},
	});
</script>
