<template>
    <div class="bg-gray p-2">
        <div class="row text-center">
            <!-- <h5>Datos Del Cliente</h5> -->
        </div>
        <div class="row">
            <div class="col-2">
                Cédula:
            </div>
            <div class="col">
                {{ invoice.form.client.document }}
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Nombre:
            </div>
            <div class="col">
                {{ invoice.form.client.first_name }} {{ invoice.form.client.last_name }}
            </div>
        </div>
        <div class="border border-bottom border-white my-1"></div>
        <div class="row text-center">
            <!-- <h5>Productos</h5> -->
        </div>
        <div class="row">
            <div class="col-3 align-self-center">
                Nombre
            </div>
            <div class="col-2 align-self-center">
                Cant.
            </div>
            <div class="col-3 align-self-center">
                Precio
            </div>
            <div class="col-3 align-self-center">
                Subtotal
            </div>
            <div class="col-1 align-self-center">
            </div>
        </div>

        <div class="row" v-for="item, i in invoice.products" :key="i">
            <div class="col-3 align-self-center">
                {{ item.name }}
            </div>
            <div class="col-2 align-self-center">
                <span v-show="!showInputCant[i]" @dblclick="showInputCant[i] = true">{{ item.quantity }}</span>
                <input
                    v-show="showInputCant[i]"
                    @dblclick="changeCantidad(i)"
                    @keypress.enter="changeCantidad(i)"
                    @blur="changeCantidad(i)"
                    type="text"
                    class="form-control" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"
                    v-model="products[i].quantity" />

            </div>
            <div class="col-3 align-self-center">
                {{ item.price }}
            </div>
            <div class="col-3 align-self-center">
                {{ subTotal(item) }}
            </div>
            <div class="col-1 align-self-center">

                <i class="fas fa-minus" style="cursor: pointer" @click="invoice.deleteProduct(i)">
                </i>
            </div>
        </div>
        <div class="row border border-top border-white">
            <div class="col text-right">
                <h6>Total</h6>
            </div>
            <div class="col">
                {{ invoice.getAcumByProducts }}
            </div>
            <div class="col text-right">
                <h6>Articulos</h6>
            </div>
            <div class="col">
                {{ leftView.cantArticulos }}
            </div>
        </div>

        <div class="row text-center">
            <!-- <h5>Pagos</h5> -->
        </div>
        <div class="row">
            <div class="col-3 align-self-center">
                Tipo
            </div>
            <div class="col-2 align-self-center">
                Método
            </div>
            <div class="col-3 align-self-center">
                Monto
            </div>
            <div class="col-3 align-self-center">
                Obs.
            </div>
            <div class="col-1 align-self-center">
            </div>
        </div>

        <div class="row" v-for="item, i in invoice.form.payments" :key="i">
            <div class="col-3 align-self-center">
                {{ item.type }}
            </div>
            <div class="col-2 align-self-center">
                {{ item.method }}

            </div>
            <div class="col-3 align-self-center">
                {{ item.quantity }}
            </div>
            <div class="col-3 align-self-center">
                {{ item.description }}
            </div>
            <div class="col-1 align-self-center">

                <i class="fas fa-minus" style="cursor: pointer" @click="invoice.deletePayment(i)">
                </i>
            </div>
        </div>
        <div class="row border border-top border-white">
            <div class="col text-right">
                <h6>Falta Pagar</h6>
            </div>
            <div class="col">
                {{ invoice.getAcumByProducts - invoice.getAcumByPayments }}
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref, computed } from "vue"
import { InvoiceStore } from "../InvoiceStore";
import { storeToRefs } from "pinia";
import { LeftViewStore } from "./LeftViewStore";

const leftView = LeftViewStore()
const invoice = InvoiceStore()
const { products,payment } = storeToRefs(invoice)

const dataClient = [
    {
        label: 'Cédula',
        name: 'document'
    },
    {
        label: 'Nombre',
        name: 'fullname'
    }
]

const fieldProduct = (item) => {
    return `${item.price} x ${item.quantity} und`
}

const subTotal = (item) => {
    return item.quantity * item.price
}

const showInputCant = ref([])

const changeCantidad = (i) => {
    showInputCant.value[i] = false
    payment.value.quantity = invoice.getAcumByProducts - invoice.getAcumByPayments
}
</script>
<style scoped>
.bg-gray {
    background-color: #ececec;
}
</style>
