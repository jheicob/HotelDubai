<template>
	<div class="row justify-content-center">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Facturas</li>
		</ol>

		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
				Facturas
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<div class="col text-right">
						<!--<a
							data-toggle="modal"
							v-on:click.prevent="useStore.ShowCreateModal()"
							v-if="useHelper.permiss.create"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<i class="fas fa-check"></i>
							<span class="text font-montserrat font-weight-bold"
								>Crear Tipo Habitacion</span
							>
						</a>-->
					</div>
					<table
						class="table table-bordered"
						id="dataTable"
						width="100%"
						cellspacing="0"
					>
						<thead>
							<tr>
								<th>ID</th>
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Total</th>
								<th>Estado</th>
								<th>Accion</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>ID</th>
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Total</th>
								<th>Estado</th>
								<th>Accion</th>
							</tr>
						</tfoot>
						<tbody>
							<tr v-for="keep in useHelper.all" :key="keep.id">
								<td>{{ keep.id }}</td>
								<td>{{ keep.attributes.date }}</td>
								<td>
									{{
										useStore.getClientFullName(
											keep.relationships.client
										)
									}}
								</td>
								<td>{{ keep.attributes.total }}</td>
								<td>{{ keep.attributes.status }}</td>
								<td>
									<i
										v-on:click.prevent="useStore.showDetails(keep)"
										class="ico fas fa-eye fa-lg text-secondary mr-2"
										style="cursor: pointer"
										title="Ver Detalle"
									></i>
									<i
										v-on:click.prevent="useStore.printFiscalInvoice(keep)"
										class="ico fas fa-print fa-lg text-secondary mr-2"
										v-if="useStore.isPrintable(keep)"
										style="cursor: pointer"
										title="Imprimir"
									></i>
	<i
										v-on:click.prevent="useStore.printFiscalInvoice(keep,true)"
										class="ico fas fa-window-close fa-lg text-secondary mr-2"
										v-if="useStore.isCancellable(keep)"
										style="cursor: pointer"
										title="Devolucion"
									></i>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--
		<CreatePermission />
-->
		<Detail />
	</div>
</template>

<script setup>
	// this composition component vue 3
	import { onMounted } from "vue";
	//	import CreatePermission from "../Modals/CreateRoomType.vue";
	import Detail from "../Modals/ShowDetail.vue";

	//import store of component
	import { InvoiceStore } from "../InvoiceStore";

	// import helperStore
	import { HelperStore } from "@/HelperStore";

	const useHelper = HelperStore();
	const useStore = InvoiceStore();
	useHelper.url = "invoice";

	onMounted(() => {
		//		useStore.getRoomTypes();

		useHelper.getAll();
	});
</script>
