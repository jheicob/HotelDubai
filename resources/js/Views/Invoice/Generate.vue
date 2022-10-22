<template>
	<div class="row justify-content-center">
	<div class="col-md-12">
		<div
			class="modal fade"
			id="exampleModal23"
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
							Generar Factura
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
						<div class='row'>
							¿Se aplicará el Impuesto a Grandes Transacciones Financieras? (IGTF)
						</div>
						<div class='row'>
							<button
								class='btn btn-info'
								@click="store.printInvoice(false)"
								>
								No
							</button>
							<button
								class='btn btn-danger'
								@click="store.printInvoice(true)"
								>
								Sí
							</button>
						</div>
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
		<!--
		<table
			class="table"
			>
			<thead>
				<tr>
					<th>
						Producto
					</th>
					<th>
						Cantidad
					</th>
					<th>
						Precio
					</th>
					<th>
						Horas Adicionales
					</th>
					<th>
						Precio X Hora Addicional
					</th>
			</tr>
			</thead>
		<tbody>
			<tr>
				<td>
				</td>
			</tr>
		</tbody>
	</table>-->
	</div>
	</div>
</template>

<script setup>
	//import { HelperStore } from "../../HelperStore";
	import { InvoiceStore} from './InvoiceStore'

	//const useHelper = HelperStore();
	const store = InvoiceStore();

</script>
