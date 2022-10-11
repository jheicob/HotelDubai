<template>
	<div
		class="modal fade"
		:id="idModal"
		tabindex="-1"
		role="dialog"
		aria-labelledby="exampleModalLabel"
		aria-hidden="true"
	>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header py-2" v-if="title">
					<slot name="title" id="exampleModalLabel">Titulo</slot>
					<a
						type="button"
						class="close"
						data-dismiss="modal"
						aria-label="Close"
					>
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<slot>Body</slot>
				</div>
				<div class="modal-footer" v-if="footer">
					<slot name="footer"> footer</slot>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import { ref, toRefs } from "vue";
	import { HelperStore } from "@/HelperStore";

	const helper = HelperStore();

	const props = defineProps({
		idModal: String,
		footer: {
			type: Boolean,
			default: false,
		},
		title: {
			type: Boolean,
			default: false,
		},
	});
</script>
<style></style>
