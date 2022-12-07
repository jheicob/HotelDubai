<template>

    <div class="modal-header py-2">
        <h5 class="modal-title title-page text-secondary" id="exampleModalLabel">
            Punto Venta
        </h5>
    </div>
    <div class="modal-body">
        <div>
            <buton class="btn btn-primary" @click="(showClient = !showClient)">
            Cliente
            </buton>
        </div>
        <div v-show="showClient">
            <div class="row">
                <div class="col-4">
                    <label for="tipo_documento" class="form-label">
                        Tipo Documento:
                    </label>

                    <select name="tipo_documento" id="tipo_documento" required v-model="form.client.type_document_id"
                        class="form-select">
                        <!-- ?php foreach ($tipo_documentos as $tipo_documento) : ?> -->
                        <option value="">Seleccione...</option>
                        <option v-for="(
                                                type_document, i
                                            ) in ocuppy.type_documents" :key="i" :value="type_document.id">
                            {{ type_document.attributes.name }}
                        </option>
                        <!-- ?php endforeach; ?> -->
                    </select>
                </div>
                <div class="col">
                    <label class="form-label" for="documento">
                        Documento:
                    </label>
                    <input type="text" class="form-control" name="documento" id="documento" required="required"
                        placeholder="Ingresar documento para buscar" v-model="form.client.document" @blur="getClient" />
                </div>
                <!-- /.input group -->
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label" for="nombre">
                        Nombres:
                    </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required
                        v-model="form.client.first_name" placeholder="Ingrese nombres" />
                </div>
                <!-- /.input group -->
                <div class="col">
                    <label class="form-label" for="apellido">
                        Apellidos:
                    </label>
                    <input type="text" class="form-control" placeholder="Ingrese Apellidos" v-model="form.client.last_name"
                        name="apellido" id="apellido" />
                </div>
            </div>
        </div>
        <div class="my-2"></div>
        <h3>Productos</h3>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripcion</th>
                    <th class="col-2">Cantidad</th>
                    <th>Precio</th>
                    <th>SubTotal</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, i) in store.products" :key="i">
                    <td>{{ item.name }}</td>
                    <td>{{ item.description }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.price }}</td>
                    <td>
                        {{ item.price * item.quantity }}
                    </td>
                    <td>
                        <i class="fas fa-minus" style="cursor: pointer" @click="store.deleteProduct(i)">
                        </i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <multiselect id="checkedPermissions" v-model="product" :options="ocuppy.products" label="name"
                            track-by="id">
                        </multiselect>
                    </td>
                    <td>
                        {{ product.description }}
                    </td>
                    <td>
                        <input type="number" min="0" class="form-control" v-model="product.quantity" />
                    </td>
                    <td>
                        {{ product.price }}
                    </td>
                    <td>
                        {{ product.quantity * product.price }}
                    </td>
                    <td colspan="5">
                        <i class="fas fa-plus" style="cursor: pointer" @click="addProductInInvoice">
                        </i>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Total</th>
                    <th>
                        {{ store.getAcumByProducts }}
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
                <tr v-for="(pay, i) in store.form.payments" :key="i">
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
                        <i class="fas fa-minus" style="cursor: pointer" @click="store.deletePayment(i)">
                        </i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select class="form-select" v-model="store.payment.type">
                            <option value="Bs">Bs</option>
                            <option value="divisa">
                                Divisa
                            </option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" v-model="store.payment.method">
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
                        <input type="number" class="form-control" v-model="store.payment.quantity" />
                    </td>
                    <td>
                        <input class="form-control" v-model="store.payment.description" />
                    </td>

                    <td colspan="5">
                        <i class="fas fa-plus" style="cursor: pointer" @click="store.addPayment">
                        </i>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="justify-content-end mt-3 row">
            <SelectCaja class="col-3"></SelectCaja>
        </div>
    </div>
    <div class="modal-footer">
        <a class="btn btn-danger text-white btn-icon-split mb-4" data-dismiss="modal" @click="clearForm">
            <span class="text font-montserrat font-weight-bold">Cancelar</span>
        </a>
        <button
            :disabled="disabledButton()"
            class="btn btn-primary text-white btn-icon-split mb-4"
            @click="createInvoice" type="button"
            >
            <span class="text font-montserrat font-weight-bold">Facturar</span>
        </button>
    </div>
</template>

<script setup>
import { onMounted,ref } from "vue";
import { InvoiceStore } from "../InvoiceStore";
import { HelperStore } from "@/HelperStore";
import { ocuppyRoomStore } from "../../Room/Modals/OcuppyRoomStore";
import { storeToRefs } from "pinia";
import Multiselect from "vue-multiselect";
import SelectCaja from "../../Room/Modals/SelectCaja.vue";

const props = defineProps({
    fiscal_machine_id: {
        type: String,
        default: "",
    }

})

const ocuppy = ocuppyRoomStore();
const store = InvoiceStore();
const useHelper = HelperStore();
const { caja_fiscal } = storeToRefs(useHelper)

const disabledButton = () => {

    if(useHelper.desactiveButton){
        return true
    }
    return (!store.verifyEqualPaymentAndAcum || useHelper.caja_fiscal == '')
}
const changeProduct = () => {

    axios
        .get('/invoice/Product/get?')
        .then(res => {
            products_get.value = res.data.data
        })
        .catch(err => useHelper.getErrorRequest(err))

}
const clearForm = () => {
    productInvoice.value = [];
    form.value.payments = [];
};

const { products: productInvoice, form, payment } = storeToRefs(store);
const { products: products_get, client_exist, type_documents, date, hour, product, click_in_bodegon } =
    storeToRefs(ocuppy);

const addProductInInvoice = () => {
    productInvoice.value.push(ocuppy.product);
    ocuppy.clearProduct();
    payment.value.quantity = store.getAcumByProducts - store.getAcumByPayments;
};

const storeClient = () => {
    let data = {
        document: form.value.client.document,
        type_document_id: form.value.client.type_document_id,
        first_name: form.value.client.first_name,
        last_name: form.value.client.last_name,

    };
    axios
        .post("/client/create", data)
        .then((response) => {
            form.value.client_id = response.data.data.id;
            printInvoice();
        })
        .catch((err) => useHelper.getErrorRequest(err));
};

const createInvoice = () => {
    if (!client_exist.value) {
        storeClient()
        return
    }
    printInvoice()
}

const printInvoice = () => {
    let url = "/invoice/create";
    let data = {
        client_id: form.value.client_id,
        payments: form.value.payments,
        products: productInvoice.value,
        fiscal_machine_id: useHelper.caja_fiscal
    };
    axios
        .post(url, data)
        .then((res) => {
            let id = res.data.message.id;
            window.open("/invoice/printFiscal/" + id);
            location.reload();
            $("#bodegon").modal("hide");
        })
        .catch((err) => useHelper.getErrorRequest(err));
};

const getClient = () => {
    client_exist.value = false;
    let params = {
        document: form.value.client.document,
    };
    axios
        .get("/client/get", { params })
        .then((response) => {
            let res = response.data.data;
            if (res.length > 0) {
                res = res[0];
                console.log(res);
                form.value.client_id = res.id;
                form.value.client.document = res.attributes.document;
                form.value.client.type_document_id = res.attributes.type_document_id;
                form.value.client.first_name = res.attributes.first_name;
                form.value.client.last_name = res.attributes.last_name;
                client_exist.value = true;
            } else {
                form.value.client_id = '';
                form.value.client.first_name = "";
                form.value.client.last_name = "";
            }
        })
        .catch((err) => helper.getErrorRequest(err));
};
onMounted(() => {
    caja_fiscal.value = props.fiscal_machine_id

    ocuppy.getTypeDocuments();
    click_in_bodegon.value = true;
    ocuppy.getProducts();

    form.value = {
        reception_details: "",
        client_id: '',
        client: {
            id: '',
            document: '',
            type_document_id: '',
            first_name: '',
            last_name: '',
        },
        reception_details: [],
        payments: [],
    }
});

const showClient = ref(false)
</script>
