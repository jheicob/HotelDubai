<template>
	<div class="row justify-content-center">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Productos</li>
		</ol>

		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fas fa-table"></i>
				Data Productos
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<div class="col text-right">
						<a
							data-toggle="modal"
							v-on:click.prevent="useStore.ShowCreateModal()"
							v-if="useHelper.permiss.create"
							class="btn btn-primary text-white btn-icon-split mb-4"
						>
							<i class="fas fa-check"></i>
							<span class="text font-montserrat font-weight-bold"
								>Crear Producto</span
							>
						</a>
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
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Precio Compra</th>
								<th>Precio Venta</th>
								<th>Visible Factura</th>
								<th>Disponibles</th>
								<th>Stock mínimo</th>
								<th>Código de Barra</th>

								<th>Accion</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Precio Compra</th>
								<th>Precio Venta</th>
								<th>Visible Factura</th>
								<th>Disponibles</th>
								<th>Stock mínimo</th>
								<th>Código de Barra</th>

								<th>Accion</th>
							</tr>
						</tfoot>
						<tbody>
							<tr v-for="keep in useStore.all" :key="keep.id">
								<td>{{ keep.id }}</td>
								<td>{{ keep.attributes.name }}</td>
								<td>{{ keep.attributes.description }}</td>
								<td>{{ keep.attributes.purchase_price }}</td>
								<td>{{ keep.attributes.sale_price }}</td>
								<td>
									{{ keep.attributes.visible == true ? "Sí" : "No" }}
								</td>
								<td>
									{{ keep.relationships.inventory.attributes.stock }}
								</td>
								<td>
									{{
										keep.relationships.inventory.attributes.stock_min
									}}
								</td>
								<td></td>
								<td>
									<i
										v-on:click.prevent="
											useStore.ShowUpdateModel(keep)
										"
										v-if="useHelper.permiss.updated"
										class="ico fas fa-edit fa-lg text-secondary"
										style="cursor: pointer"
										title="Borrar"
									></i>

									<i
										v-on:click.prevent="useStore.deleteRoomType(keep)"
										v-if="useHelper.permiss.deletet"
										:class="
											keep.attributes.deleted_at
												? 'ico fas fa-trash-restore-alt fa-lg text-secondary'
												: 'ico fas fa-trash fa-lg text-secondary'
										"
										style="cursor: pointer"
										title="Borrar"
									></i>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<CreatePermission />
		<UpdatePermission />
	</div>
</template>

<script setup>
	// this composition component vue 3
	import { onMounted } from "vue";
	import CreatePermission from "../Modals/CreateProduct.vue";
	import UpdatePermission from "../Modals/UpdateProduct.vue";

	//import store of component
	import { RoomTypeStore } from "../ProductStore";

	// import helperStore
	import { HelperStore } from "@/HelperStore";

	const useHelper = HelperStore();
	const useStore = RoomTypeStore();

	onMounted(() => {
		useStore.getRoomTypes();
	});
</script>
