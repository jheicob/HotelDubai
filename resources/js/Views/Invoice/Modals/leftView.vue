<template>
    <!-- <div class="modal-header py-2">
        <h5 class="modal-title title-page text-secondary" id="exampleModalLabel">
            Punto Venta
        </h5>
    </div> -->
    <!-- <div class="modal-body"> -->

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
        <div v-show="showProducs">
            <div class="input-group mb-3 col-4">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-search"></i>
                </span>
                <input
                    autofocus
                    type="text"
                    class="form-control"
                    placeholder="buscar producto...."
                    aria-label="Username"
                    aria-describedby="basic-addon1"
                    @keypress.enter="searchProduct"
                    @blur="searchProduct"
                    v-model="search"
                />
            </div>
            <div class="row">
                <div class="col">
                    <button
                        class="btn m-1 "
                        type="button"
                        v-for="item,i in ListProductCategory"
                        :class="'btn-'+colors[i]"
                        @click="setButtonProducts(item,i)"
                        :key="i"
                    >
                    {{item.attributes.name}}
                    </button>
                </div>
            </div>
            <hr class="border border-danger border-2 opacity-50">
            <div class="row">
                <div class="col">
                    <button
                        class="btn m-1"
                        type="button"
                        v-for="item,i in buttonProducts"
                        :key="i"
                        :class="colorProduct"
                        @click="addProductInInvoice(item)"
                    >
                    {{item.attributes.name}}
                    </button>
                </div>
            </div>
        </div>



        <div class="my-2"></div>
        <div class="col" v-show="showPayments">
            <!-- <h3>Pagos</h3> -->
        </div>

        <table class="table text-center" v-show="showPayments">
            <thead>
                <tr>
                    <th>Tipo de Pago</th>
                    <th>M??todo de Pago</th>
                    <th>Monto</th>
                    <th>Observacion</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>

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
        <!-- <div class="justify-content-end mt-3 row">
            <SelectCaja class="col-3"></SelectCaja>
        </div> -->
    <!-- </div> -->
    <!-- <div class="modal-footer">
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
    </div> -->
</template>

<script setup>
import { onMounted,ref,computed } from "vue";
import { InvoiceStore } from "../InvoiceStore";
import { HelperStore } from "@/HelperStore";
import { ocuppyRoomStore } from "../../Room/Modals/OcuppyRoomStore";
import { storeToRefs } from "pinia";
import Multiselect from "vue-multiselect";
import SelectCaja from "../../Room/Modals/SelectCaja.vue";
import axios from "axios";
import {LeftViewStore} from './LeftViewStore.js'

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

const cantArticulos = computed(()=>{
    let acum = 0;
    productInvoice.value.forEach((product)=>{
        acum += product.quantity
    })
    return acum;
})
const addProductInInvoice = (item = null) => {
    if(item){
        product.value = {
            id: item.id,
            name: item.attributes.name,
            description: item.attributes.description,
            price:item.attributes.sale_price,
            quantity:1,
            type:"Product"

        }
        product.value.quantity = 1
    }
    let bool = productInvoice.value.find(prod => prod.id == item.id)
    console.log('producto', bool)
    if(!bool){
        console.log('if')

        productInvoice.value.push(ocuppy.product);
    }else{
        productInvoice.value.find(prod => prod.id == item.id).quantity ++;
    }
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
    getProductCategories()
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

const leftView =  LeftViewStore()

const {
    showClient,
    showProducs,
    showPayments,
    colorProduct
} = storeToRefs(leftView)

const {showElement,colors} = leftView

const productCategory = ref('')
const ListProductCategory = ref([])

const getProductCategories = () =>{
    let url = '/configuracion/ProductCategory/get?slash_code='+productCategory.value
    axios
        .get(url)
        .then(res => {
            ListProductCategory.value = res.data.data
            buttonProducts.value = ListProductCategory.value[0].relationships.products
            colorProduct.value = `btn-${colors[0]}`
            nombreCategoria.value = ListProductCategory.value[0].attributes.name
        })
        .catch(err => useHelper.getErrorRequest(err))
}

const buttonProducts = ref([])
const nombreCategoria = ref('')
const setButtonProducts = (item,i) => {
    colorProduct.value = `btn-${colors[i]}`
    nombreCategoria.value = item.attributes.name

    buttonProducts.value = item.relationships.products
}

const search = ref('')
const searchProduct = ()=>{
    let url = '/invoice/Product/get?search='+search.value
    if(!search.value) return
    axios
       .get(url)
       .then(res => {
            if(res.data.data.length == 1){
                addProductInInvoice(res.data.data[0])
            }
            search.value = ''
       })
       .catch(err => useHelper.getErrorRequest(err))
}
</script>
