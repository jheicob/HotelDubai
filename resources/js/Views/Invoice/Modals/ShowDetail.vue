<template>
	<form>
		<!-- Modal -->
		<div
			class="modal fade"
			id="exampleModal2"
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
							Detalle de Factura
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
						<table
						    class="table table-bordered"
		  cellspacing="0">
							<thead>
								<tr>
									<th>Producto</th>
									<th>Cantidad</th>
									<th>Precio</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="detail in useStore.details" :key="detail.id">
									<td>
										{{detail.attributes?.product_name ?? ''}}
									</td>
									<td>
										{{detail.attributes?.quantity ?? ''}}
									</td>
									<td>
										{{detail.attributes?.price ?? ''}}
									</td>
									<td>
										{{(detail.attributes?.price ?? 1) * (detail.attributes?.quantity ?? 1)}}
									</td>
								</tr>

							</tbody>
						</table>
					</div>
				<div class="modal-footer">
						<a
							class="btn btn-danger text-white btn-icon-split mb-4"
							data-dismiss="modal"
						>
							<span class="text font-montserrat font-weight-bold"
								>Cerrar</span
							>
						</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>

<script setup>
	import { InvoiceStore } from "../InvoiceStore.js";
	import { HelperStore } from "@/HelperStore";
	const useStore = InvoiceStore();
	const useHelper = HelperStore();
</script>
