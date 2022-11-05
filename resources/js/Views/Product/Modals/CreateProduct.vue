<template>
	<form>
		<!-- Modal -->
		<div
			class="modal fade"
			id="exampleModal"
			tabindex="-1"
			role="dialog"
			aria-labelledby="exampleModalLabel"
			aria-hidden="true"
		>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header py-2">
						<h5
							class="modal-title title-page text-secondary"
							id="exampleModalLabel"
						>
							Crear Producto
						</h5>
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
						<label for="name" class="form-label">Nombre</label>

						<input
							type="name"
							id="name"
							class="form-control form-control-user mb-3"
							autofocus
							name="name"
							v-model="useHelper.form.name"
						/>

						<label for="name" class="form-label">Descripcion</label>

						<input
							type="name"
							id="name"
							class="form-control form-control-user mb-3"
							autofocus
							name="name"
							v-model="useHelper.form.description"
						/>
						<div class="row"> 
							<div class="col">
						<label for="purchase_price" class="form-label">Precio Compra</label>

						<input
							type="number"
							min="0"
							id="name"
							class="form-control form-control-user mb-3"
							autofocus
							name="purchase_price"
							v-model="useHelper.form.purchase_price"
						/>

							</div>
							<div class="col">
						<label for="sale_price" class="form-label">Precio Venta</label>
						<input
							type="number"
	   min="0"
							id="sale_price"
							class="form-control form-control-user mb-3"
							autofocus
							name="name"
							v-model="useHelper.form.sale_price"
						/>
							</div>

						</div>
						<div class="row">
							<div class="col">
								<label for="stock" class="form-label">Disponibles</label>
								<input
									class="form-control"
									id="stock"
									type='number'
									min="0"
									v-model="useStore.inventory.stock"
									/>
							</div>
							<div class="col">
								<label for="stock_min" class="form-label">Stock Mínimo</label>
								<input
									class="form-control"
									id="stock_min"
									type='number'
									min="0" 
									v-model="useStore.inventory.stock_min"
									/>
							</div>
						</div>
						<div class="row">
							<div class="form-check form-switch form-check-reverse text-center">

							<label for="visible" class="form-check-label mx-3">¿Aparecerá en la factura? </label>
							<input class="form-check-input"
								id="visible"
								type="checkbox"
		role="switch"

									v-model="useHelper.form.visible"

								/>

						</div>
						</div>
					</div>
					<div class="modal-footer">
						<a
							class="btn btn-danger text-white btn-icon-split mb-4"
							data-dismiss="modal"
						>
							<span class="text font-montserrat font-weight-bold"
								>Cancelar</span
							>
						</a>
						<button
							:disabled="useHelper.desactiveButton"
							v-on:click.prevent="useStore.storeRoomType()"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<span class="text font-montserrat font-weight-bold"
								>Crear Producto</span
							>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>

<script setup>
	import { onMounted } from "vue";
	import { RoomTypeStore } from "../ProductStore";
	import { HelperStore } from "@/HelperStore";

	const useStore = RoomTypeStore();
	const useHelper = HelperStore();

	onMounted(() => {
		useStore.clearForm();
	});
</script>
