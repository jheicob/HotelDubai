<template>
	<div class="row">
		<!-- col -->
		<div class="col-md-12">
			<section class="tile">
				<div class="tile-header dvd dvd-btm">
					<div class="box-header with-border">
						<h3 class="box-title">Datos de la habitación</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="table-responsive">
							<table class="table no-margin">
								<tbody style="padding: 0px">
									<tr style="padding: 0px">
										<td>
											<h4
												class="text-primary"
												style="margin-top: 0px !important"
											>
												Nombre:
											</h4>
										</td>
										<td>
											{{ item.attributes?.name ?? "" }}
										</td>
										<td>
											<h4
												class="text-primary"
												style="margin-top: 0px !important"
											>
												Tipo:
											</h4>
										</td>
										<td>
											<div
												class="sparkbar"
												data-color="#00a65a"
												data-height="20"
											>
												{{
													item.relationships?.partialCost
														.relationships.roomType.attributes
														.name ?? ""
												}}
											</div>
										</td>
									</tr>
									<tr style="padding: 0px">
										<td>
											<h4
												class="text-primary"
												style="margin-top: 0px !important"
											>
												Detalles:
											</h4>
										</td>
										<td>
											{{ item.attributes?.description ?? "" }}
										</td>
										<td>
											<h4
												class="text-primary"
												style="margin-top: 0px !important"
											>
												Estado:
											</h4>
										</td>
										<td>
											<div
												class="sparkbar"
												data-color="#f39c12"
												data-height="20"
											>
												<span class="label label-success"
													>DISPONIBLE</span
												>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.table-responsive -->
					</div>
				</div>
				<!-- /.box -->
				<!-- Modal -->
				<form
					class="form-horizontal"
					method="post"
					id="addproduct"
					action="index.php?view=addproceso"
					role="form"
				>
					<div class="box box-info row">
						<div class="box-body col-md-6">
							<div class="table-responsive">
								<div class="">
									<table class="table no-margin">
										<tr>
											<th colspan="4" style="text-align: center">
												DATOS DEL CLIENTE
											</th>
										</tr>
										<tbody style="padding: 0px">
											<tr style="padding: 0px">
												<td colspan="2">
													<div class="row">
														<div class="col-4">
															<label
																for="tipo_documento"
																class="form-label"
															>
																Tipo Documento:
															</label>

															<select
																name="tipo_documento"
																id="tipo_documento"
																required
																:disabled="
																	store.updated_reception
																"
																v-model="
																	form.type_document_id
																"
																class="form-select"
															>
																<!-- ?php foreach ($tipo_documentos as $tipo_documento) : ?> -->
																<option value="">
																	Seleccione...
																</option>
																<option
																	v-for="(
																		type_document, i
																	) in ocuppy.type_documents"
																	:key="i"
																	:value="
																		type_document.id
																	"
																>
																	{{
																		type_document
																			.attributes
																			.name
																	}}
																</option>
																<!-- ?php endforeach; ?> -->
															</select>
														</div>
														<div class="col">
															<label
																class="form-label"
																for="documento"
															>
																Documento:
															</label>
															<input
																type="text"
																class="form-control"
																:disabled="
																	store.updated_reception
																"
																name="documento"
																id="documento"
																required="required"
																placeholder="Ingresar documento para buscar"
																v-model="form.document"
																@blur="ocuppy.getClient"
															/>
														</div>
														<!-- /.input group -->
													</div>
													<div class="row">
														<div class="col">
															<label
																class="form-label"
																for="nombre"
															>
																Nombres:
															</label>
															<input
																type="text"
																class="form-control"
																name="nombre"
																id="nombre"
																required
																:disabled="
																	store.updated_reception
																"
																v-model="form.first_name"
																placeholder="Ingrese nombres"
															/>
														</div>
														<!-- /.input group -->
														<div class="col">
															<label
																class="form-label"
																for="apellido"
															>
																Apellidos:
															</label>
															<input
																type="text"
																:disabled="
																	store.updated_reception
																"
																class="form-control"
																placeholder="Ingrese Apellidos"
																v-model="form.last_name"
																name="apellido"
																id="apellido"
															/>
														</div>
													</div>
													<div class="row">
														<div class="col">
															<label
																class="form-label"
																for="telefono"
															>
																Teléfono:
															</label>
															<input
																type="text"
																class="form-control"
																:disabled="
																	store.updated_reception
																"
																placeholder="Ingrese teléfono"
																name="telefono"
																id="telefono"
																v-model="form.phone"
															/>
														</div>
														<!-- /.input group -->
														<div class="col">
															<label
																class="form-label"
																for="direccion"
															>
																E-mail:
															</label>
															<input
																type="text"
																class="form-control"
																name="direccion"
																id="direccion"
																:disabled="
																	store.updated_reception
																"
																v-model="form.email"
																placeholder="Ingrese correo electronico "
															/>
														</div>
														<!-- /.input group -->
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<table class="table no-margin">
								<thead>
									<tr>
										<th colspan="4" style="text-align: center">
											DATOS DEL ALOJAMIENTO
										</th>
									</tr>
								</thead>
								<tbody style="padding: 0px">
									<tr style="padding: 0px">
										<td colspan="4">
											<div class="row">
												<div class="col">
													<label class="form-label"
														>Fecha de Entrada</label
													>
													<input
														v-model="date"
														type="date"
														class="form-control"
														:disabled="!client_exist"
													/>
												</div>
												<div class="col">
													<label class="form-label"
														>Hora de Entrada</label
													>
													<input
														v-model="hour"
														type="time"
														class="form-control"
														:disabled="!client_exist"
													/>
												</div>
											</div>
											<div class="row">
												<div class="col-8" v-if="false">
													<label class="form-label"
														>Cantidad de parciales</label
													>
													<input
														v-model="form.quantity_partial"
														type="number"
														class="form-control"
														:disabled="!client_exist"
													/>
													<div class="row">
														<div
															id="emailHelp"
															class="form-text col"
														>
															Parcial mínimo:
															{{
																item.attributes
																	?.rate_current ?? ""
															}}
														</div>
														<div
															id="emailHelp"
															class="form-text col"
														>
															Tarifa: $
															{{
																item.relationships
																	?.partialCost
																	.attributes.rate ?? ""
															}}
														</div>
													</div>
												</div>
												<div class="col" v-if="false">
													<label
														class="form-label"
														for="ticket"
													>
														Tickera
													</label>
													<select
														class="form-select"
														id="ticket"
														v-model="form.ticket_op"
													>
														<option
															v-for="(item, i) in opTickets"
															:key="i"
															:value="item.id"
														>
															{{ item.name }}
														</option>
													</select>
												</div>
											</div>
											<div>
												<label class="form-label"
													>Observaciones</label
												>
												<input
													v-model="form.observation"
													type="text"
													class="form-control"
													:disabled="!client_exist"
												/>
											</div>

											<div
												class="row justify-content-between mt-4"
											></div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- /.table-responsive -->
					<div class="row justify-content-between mx-5">
						<button
							class="btn btn-info col-1"
							@click.prevent="store.show = false"
						>
							Regresar
						</button>

						<a
							class="btn btn-danger text-white btn-icon-split col-1"
							@click="store.cancelUse(item)"
							v-if="store.updated_reception"
						>
							<span class="text font-montserrat font-weight-bold"
								>Cancelar</span
							>
						</a>

						<button
							v-if="store.updated_reception"
							class="btn btn-success text-white btn-icon-split col-1"
							type="button"
							@click.prevent="openModal()"
						>
							Facturar
						</button>

						<TransferirHabVue :room_id="item.id" />
						<!-- <button
                            :disabled="desactiveButton"
                            v-on:click.prevent="storeAssignedRoom()"
                            class="btn btn-primary text-white btn-icon-split col-2"
                        > -->
						<button
							:disabled="desactiveButton"
							v-on:click.prevent="asignarHab()"
							class="btn btn-primary text-white btn-icon-split col-2"
						>
							<span class="text font-montserrat font-weight-bold">{{
								store.updated_reception
									? "Extender Tiempo"
									: "Asignar Habitación"
							}}</span>
						</button>
					</div>
				</form>
			</section>
			<div
				class="modal fade"
				id="exampleModal23"
				tabindex="-1"
				role="dialog"
				aria-labelledby="exampleModalLabel"
				aria-hidden="true"
			>
				<div class="modal-dialog modal-xl" role="document">
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
							<div class="row">
								<h3>Costos de Habitación</h3>
								<table class="table text-center">
									<thead>
										<tr>
											<th>Parciales</th>
                                            <th>cantidad por parcial</th>
											<th>Precio x Parcial</th>
											<th>Parcial Adicional</th>
											<th>Observacion</th>
											<th>Precio x Parcial Adicional</th>
											<th>total</th>
										</tr>
									</thead>
									<tbody>
										<tr
											v-for="(detail, i) in invoice.form
												.reception_details"
											:key="i"
										>
											<td>
												{{ detail.partial_min ?? "" }}
											</td>
                                            <td>
												<input
                                                    type="number"
                                                    class="form-control"
                                                    :disabled="invoice.form.reception_details.length != i+1 || click_in_invoice"
                                                    v-model="detail.quantity_partial"
                                                    @change="setPayment"
                                                    />
											</td>
											<td>
												{{ detail.rate ?? "" }}
											</td>
											<td>
												<div
													class="input-group mb-3 col mx-auto"
												>
													<input
														type="number"
														class="form-control"
                                                        :disabled="!store.updated_reception || !click_in_invoice "

														v-model="
															invoice.form
																.reception_details[i]
																.time_additional
														"
                                                    @change="setPayment"
														aria-describedby="basic-addon2"
														min="0"
													/>
													<span
														class="input-group-text"
														id="basic-addon2"
														>x
														{{
															detail.partial_min ?? ""
														}}</span
													>
												</div>
											</td>
											<td>
												<input
													class="form-control"
                                                    :disabled="!store.updated_reception || !click_in_invoice "
                                                    @change="setPayment"
													v-model="
														invoice.form.reception_details[i]
															.observation
													"
												/>
											</td>
											<td>
												<input
													type="number"
													class="col form-control mx-auto"
                                                    :disabled="!store.updated_reception || !click_in_invoice "

                                                    @change="setPayment"

													v-model="
														invoice.form.reception_details[i]
															.price_additional
													"
												/>
											</td>
											<td>
												{{ invoice.getTotalByDetails(i) }}
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="5">Total</th>
											<th>
												{{ invoice.getAcumTotalByDetails }}
											</th>
										</tr>
									</tfoot>
								</table>

								<div class="my-2"></div>
                                <h3 v-show="click_in_invoice">Pagos Extra</h3>
                                <table class="table text-center" v-show="click_in_invoice">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>SubTotal</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                item, i
                                            ) in invoice.products"
                                            :key="i"
                                        >
                                            <td>{{ item.name }}</td>
                                            <td>{{ item.description }}</td>
                                            <td>{{ item.quantity }}</td>
                                            <td>{{ item.price }}</td>
                                            <td>
                                                {{ item.price * item.quantity }}
                                            </td>
                                            <td>
                                                <i
                                                    class="fas fa-minus"
                                                    style="cursor: pointer"
                                                    @click="
                                                        invoice.deleteProduct(i)
                                                    "
                                                >
                                                </i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <multiselect
                                                    id="checkedPermissions"
                                                    v-model="product"
                                                    :options="ocuppy.products"
                                                    label="name"
                                                    track-by="id"
                                                >
                                                </multiselect>
                                            </td>
                                            <td>
                                                {{ product.description }}
                                            </td>
                                            <td>
                                                <input
                                                    type="number"
                                                    min="0"
                                                    class="form-control"
                                                    v-model="product.quantity"
                                                />
                                            </td>
                                            <td>
                                                {{ product.price }}
                                            </td>
                                            <td>
                                                {{
                                                    product.quantity *
                                                    product.price
                                                }}
                                            </td>
                                            <td colspan="5">
                                                <i
                                                    class="fas fa-plus"
                                                    style="cursor: pointer"
                                                    @click="addProductInInvoice"
                                                >
                                                </i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <th>
                                                {{ invoice.getAcumByProducts }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
								<div class="my-2"></div>
								<div class="col">
									<h3>Pagos</h3>
								</div>

								<table class="table text-center">
									<thead>
										<tr>
											<th>Tipo de Pago</th>
											<th>Método de Pago</th>
											<th>Monto</th>
											<th>Observacion</th>
											<th>Accion</th>
										</tr>
									</thead>
									<tbody>
										<tr
											v-for="(pay, i) in invoice.form.payments"
											:key="i"
										>
											<td>
												{{ pay.type }}
											</td>
											<td>
												{{ pay.method }}
											</td>
											<td>
												{{ pay.quantity }}
											</td>
											<td>
												{{ pay.description }}
											</td>
											<td>
												<i
													class="fas fa-minus"
													style="cursor: pointer"
                                                    v-if="countPayment < i +1"
													@click="invoice.deletePayment(i)"
												>
												</i>
											</td>
										</tr>
										<tr>
											<td>
												<select
													class="form-select"
													v-model="invoice.payment.type"
												>
													<option value="Bs">Bs</option>
													<option value="divisa">Divisa</option>
												</select>
											</td>
											<td>
												<select
													class="form-select"
													v-model="invoice.payment.method"
												>
													<option value="tarjeta">
														Tarjeta
													</option>
													<option value="efectivo">
														Efectivo
													</option>
													<option value="digital">
														Digital
													</option>
												</select>
											</td>
											<td>
												<input
													type="number"
													class="form-control"
													v-model="invoice.payment.quantity"
												/>
											</td>
											<td>
												<input
													class="form-control"
													v-model="invoice.payment.description"
												/>
											</td>

											<td colspan="5">
												<i
													class="fas fa-plus"
													style="cursor: pointer"
													@click="invoice.addPayment"
												>
												</i>
											</td>
										</tr>
									</tbody>
								</table>
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
							<button
                                type="button"
								class="btn btn-success text-white btn-icon-split mb-4"
								@click="invoiceOrExtend"
                                :disabled="!invoice.verifyEqualPaymentAndAcum"
							>
                                    {{
                                    click_in_invoice
									? "Facturar"
									: "Guardar"}}
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script setup>
	import { onMounted, ref , watch} from "vue";
	import { storeToRefs } from "pinia";
	import { receptionStore } from "./ReceptionStore.js";
	import { HelperStore } from "@/HelperStore";
	import { InvoiceStore } from "../../Invoice/InvoiceStore.js";
	import { ocuppyRoomStore } from "../Modals/OcuppyRoomStore";
	import { RoomStore } from "../RoomStore";
	import Multiselect from "vue-multiselect";
	import TransferirHabVue from "./TransferirHab.vue";

    const setPayment = () => {
        payment.value.quantity = invoice.getAcumTotalByDetails
    }
    const countPayment = ref(0);


    const getPayment = () => {
        form_invoice.value.payments = []
        let payment_invoice = item.value.relationships.receptionActive.relationships.client.relationships.invoiceNoPrint.relationships.payments;
        countPayment.value = payment_invoice.length;

        payment_invoice.map(payment_i => {
            form_invoice.value.payments.push({
                id:payment_i.id,
                description: payment_i.attributes.description,
                method: payment_i.attributes.method,
                quantity: payment_i.attributes.quantity,
                type:   payment_i.attributes.type,

            })
        })
    }

	const asignarHab = () => {
        invoice_click.value = click_in_invoice.value = false
		//    console.log("aqui");

		form_invoice.value.reception_details = [];

		if (item.value.relationships.receptionActive) {
            getPayment()
			let details = item.value
                            .relationships
                            .receptionActive.relationships
                            .details;

			details.map((detail) => {
				form_invoice.value.reception_details.push({
					id: detail.id,
					partial_min: detail.attributes.partial_min,
					rate: detail.attributes.rate,
					quantity_partial: detail.attributes.quantity_partial ?? 0,
					observation: detail.attributes.observation,
					time_additional: 0,
					price_additional: detail.attributes.rate ?? 0,
				});
			});
		}
        let detail = item.value.relationships.partialCost;

        form_invoice.value.reception_details.push({
            id: null,
            partial_min: detail.relationships.partialRate.attributes.name,
            rate: detail.attributes.rate,
            quantity_partial: 1,
            observation: "",
            time_additional: 0,
            price_additional: 0,
        });
		//    console.log(details);
		payment.value.quantity = invoice.getAcumTotalByDetails;

		$("#exampleModal23").modal("show");
	};

    const invoiceOrExtend = () => {

        if(click_in_invoice.value){

            form_invoice.value.client_id = item.value.relationships.receptionActive.relationships.client.id

            return invoice.printInvoice()
        }
        console.log('asign')

        let i = form_invoice.value.reception_details.length
        form.value.quantity_partial = form_invoice.value.reception_details[i-1].quantity_partial
        return storeAssignedRoom()

    }
	const openModal = () => {
        invoice_click.value = click_in_invoice.value = true
        if(click_in_invoice.value){
            getPayment()
        }
		//    console.log("aqui");
		let details = item.value.relationships.receptionActive.relationships.details;
		//    console.log(details);
		form_invoice.value.reception_details = [];
		details.map((detail) => {
			form_invoice.value.reception_details.push({
				id: detail.id,
				partial_min: detail.attributes.partial_min,
				rate: detail.attributes.rate,
				quantity_partial: detail.attributes.quantity_partial ?? 0,
				observation: detail.attributes.observation,
				time_additional: 0,
				price_additional: detail.attributes.rate ?? 0,
			});
		});
		payment.value.quantity = invoice.getAcumTotalByDetails;

		$("#exampleModal23").modal("show");
	};

	const invoice = InvoiceStore();
	const store = receptionStore();
	const helper = HelperStore();
	const ocuppy = ocuppyRoomStore();

	const { getClient, storeAssignedRoom } = ocuppy;

	const { form, item, desactiveButton } = storeToRefs(helper);

	const { client_exist, type_documents, date, hour, product , click_in_invoice} = storeToRefs(ocuppy);

	const { form: form_invoice, payment,click_in_invoice: invoice_click } = storeToRefs(invoice);

	const opTickets = [
		{
			name: "Tarjeta",
			id: "Tarjeta",
		},
		{
			name: "Efectivo",
			id: "Efectivo",
		},
		{
			name: "Otro",
			id: "Otro",
		},
	];
	const { products: productInvoice } = storeToRefs(invoice);

	const addProductInInvoice = () => {
		productInvoice.value.push(ocuppy.product);
		ocuppy.clearProduct();
	};
	onMounted(() => {
		ocuppy.getTypeDocuments();
		ocuppy.getProducts();
	});
</script>
