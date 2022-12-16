import {defineStore} from 'pinia'
import {ref,computed} from 'vue'
import { InvoiceStore } from "../InvoiceStore";

export const LeftViewStore = defineStore('LeftView',()=>{

    const colorProduct = ref('');
    const colors = [
        "primary",
        "success",
        "info",
        "warning",
        "danger",
        "light",
        "secondary",
        "dark",
    ];
    const invoice = InvoiceStore();

    const showClient   = ref(false)
    const showProducs  = ref(false)
    const showPayments = ref(false)

    const cantArticulos = computed(()=>{
        let acum = 0;
        invoice.products.forEach((product)=>{
            acum += product.quantity
        })
        return parseInt(acum);
    })
const showElement = (name) => {
    switch(name){
        case 'Product':
            showClient.value   = false
            showProducs.value  = !showProducs.value;
            showPayments.value = false;
            break;
        case 'Payment':
            showPayments.value  = !showPayments.value
            showProducs.value  = false;
            showClient.value  = false;
            break;
        case 'Client':
            showClient.value  = !showClient.value
            showProducs.value  = false;
            showPayments.value  = false;
            break;
    }

}

return {
    colorProduct,
    cantArticulos,
    showClient,
    showElement,
    showPayments,
    showProducs,
    colors
}

})
