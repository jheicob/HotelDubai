<template>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="container">
				<div class="row">
					<h3>Configuracion General</h3>
				</div>

				<div class="row">
					<div class="col-5">
						<hr class="border border-3 border-danger">
					</div>
					<div class="col-2 text-center mb-2">
						Factura Fiscal
					</div>
					<div class="col-5">
						<hr class="border border-3 border-danger">
					</div>
					<div class="form-floating mb-3 col-6">
					  <input type="text" class="form-control" id="machine_fiscal" placeholder="AXZ-123">
					  <label for="machine_fiscal" class="mx-3">Serial de Máquina Fiscal</label>
					</div>
					<div class="form-floating mb-3 col-6">
					  <input type="text" class="form-control" id="env" placeholder="ED">
					  <label class="mx-3" for="env">Código de ambiente para impresión</label>
					</div>
				</div>
				<div class="row">
					<div class="col-5">
						<hr class="border border-3 border-danger">
					</div>
					<div class="col-2 text-center mb-2">
						Financias
					</div>
					<div class="col-5">
						<hr class="border border-3 border-danger">
					</div>
					<div class="form-floating mb-3 col-6 mx-auto">
					  <input type="number" min="0" class="form-control" id="machine_fiscal" placeholder="8.5">
					  <label for="machine_fiscal" class="mx-3">Tasa de cambio Bs/USD</label>
					</div>
				</div>
				<hr class="border border-3 border-danger">
				<div class="row my-4">
					<div class="col text-center">
					<button class="btn btn-info col-1" type="button" v-if="useHelper.permiss.upsert">
							Actualizar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
	import {ConfigurationStore} from './ConfigurationStore.js'
	import { HelperStore } from "../../HelperStore";
	import {onMounted} from 'vue'
	import {storeToRefs} from 'pinia'

	const useHelper = HelperStore();
	const store = ConfigurationStore()
	const props = defineProps({
		upsert: {
			type: Boolean,
			default: false,
		},
	});

	const {config} = storeToRefs(store)
	useHelper.permiss = props;
	
onMounted( () => {
	store.getConfiguration()
} )
</script>
