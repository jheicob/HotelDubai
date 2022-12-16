<template>
    <div class="modal-header py-2">
        <h5 class="modal-title title-page text-secondary" id="exampleModalLabel">
            Punto Venta
        </h5>
        <div class="">
            <buton class="btn btn-primary" @click="showElement('Client')">
                Cliente
            </buton>
            <buton class="btn btn-primary mx-2" @click="showElement('Product')">
                Productos
            </buton>
            <buton class="btn btn-primary" @click="showElement('Payment')">
                Pagos
            </buton>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-7 ">
                <LeftView :fiscal_machine_id="fiscal_machine_id"></LeftView>
            </div>
            <div class="col">
                <InvoiceDetail></InvoiceDetail>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a class="btn btn-danger text-white btn-icon-split mb-4 my-auto" data-dismiss="modal" @click="clearForm">
            <span class="text font-montserrat font-weight-bold">Cancelar</span>
        </a>
        <button :disabled="disabledButton()" class="my-auto btn btn-primary text-white btn-icon-split mb-4"
            @click="createInvoice" type="button">
            <span class="text font-montserrat font-weight-bold">Facturar</span>
        </button>
            <SelectCaja class="col-2 my-auto"></SelectCaja>
    </div>
</template>
<script setup>
import InvoiceDetail from './InvoiceDetail.vue';
import LeftView from './leftView.vue';
import { InvoiceStore } from "../InvoiceStore";
import { HelperStore } from "@/HelperStore";
import { ocuppyRoomStore } from "../../Room/Modals/OcuppyRoomStore";
import { storeToRefs } from "pinia";
import {LeftViewStore} from './LeftViewStore.js'
import SelectCaja from "../../Room/Modals/SelectCaja.vue";

const ocuppy = ocuppyRoomStore();
const store = InvoiceStore();
const useHelper = HelperStore();
const { caja_fiscal } = storeToRefs(useHelper)


const leftView =  LeftViewStore()

const {
    showClient,
    showProducs,
    showPayments,
} = storeToRefs(leftView)

const {showElement} = leftView

const { products: productInvoice, form, payment } = storeToRefs(store);
const { products: products_get, client_exist, type_documents, date, hour, product, click_in_bodegon } =
    storeToRefs(ocuppy);

const disabledButton = () => {


if(useHelper.desactiveButton){
    return true
}
return (!store.verifyEqualPaymentAndAcum || useHelper.caja_fiscal == '')
}
const props = defineProps({
    fiscal_machine_id: {
        type: String,
        default: "",
    }

})


const createInvoice = () => {
    if (!client_exist.value) {
        storeClient()
        return
    }
    printInvoice()
}


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


const printInvoice = () => {
    let url = "/invoice/create";
    let data = {
        client_id: form.value.client_id,
        payments: form.value.payments,
        products: productInvoice.value,
        fiscal_machine_id: useHelper.caja_fiscal,
        reception_details:[]
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
</script>
