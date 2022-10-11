<template>
	<div class="card mb-3" :style="CardStyle" :class="cardClass">
		<div class="card-header" :class="titleClass" :style="titleStyle">
			<slot name="title">Titulo</slot>
		</div>
		<div class="card-body" :class="bodyClass" :style="bodyStyle">
			<slot name="body"> Body</slot>
		</div>
		<div class="card-footer" v-if="footer" :class="footerClass" :style="footerStyle">
			<slot name="footer" />
		</div>
		<slot></slot>
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
		titleStyle: {
			type: Array,
			default: [],
		},
		bodyStyle: {
			type: Array,
			default: [],
		},
		footerStyle: {
			type: Array,
			default: [],
		},
		cardStyle: {
			type: Array,
			default: [],
		},
	});
</script>
