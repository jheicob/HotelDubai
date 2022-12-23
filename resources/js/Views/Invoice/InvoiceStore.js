import { defineStore, storeToRefs } from "pinia";
import { ref, computed } from "vue";
import axios from "axios";
import { HelperStore } from "@/HelperStore";
import { RoomStore } from "../Room/RoomStore";
import { receptionStore } from "../Room/Reception/ReceptionStore";

export const InvoiceStore = defineStore("InvoiceStore", () => {
    const roomStore = RoomStore();
    const helper = HelperStore();
    const reception = receptionStore();
    const details = ref("");
    const payment = ref({
        type: "Bs",
        method: "tarjeta",
        quantity: 0,
        description: "",
    });
    const click_in_invoice = ref(false);

    const products = ref([])

    const addProduct = (item) => {
        products.value.push(item)
    }
    const addPayment = () => {
        form.value.payments.push(payment.value);
        payment.value = {
            type: "Bs",
            method: "tarjeta",
            quantity: 0,
            description: "",
        };
    };

    const deletePayment = (index) => {
        form.value.payments.splice(index, 1);
    };
    const deleteProduct = (index) => {
        products.value.splice(index,1);
    }
    const getClientFullName = (client) => {
        return client.attributes.first_name + " " + client.attributes.last_name;
    };

    const showDetails = (item) => {
        details.value = item.relationships.details;
        $("#exampleModal2").modal("show");
    };

    const { item } = storeToRefs(helper);
    const getDetails = () => {
        details.value = item.value ?? false;
    };

    const form = ref({
        reception_details: "",
        client_id: "",
        reception_details: [],
        payments: [],
        client:{
			id: '',
			document: '',
			type_document_id: '',
			first_name:'',
			last_name:'',
		},
    });

    const generateInvoice = (room) => {
        let details = room.relationships.receptionActive.relationships.details;
        /*    for(let detail in details){
        form.value[]
    }*/
    };

    const createInvoiceOnlyProducts = () =>
    {

    }

    const getTotalByDetails = (position) => {
        let item = form.value.reception_details[position];

        let sum = 0;

        sum += parseFloat(item.rate) * parseInt(item.quantity_partial);
        sum +=
            parseFloat(item.price_additional) * parseInt(item.time_additional);

        return sum;
    };

    const acumByDetails = ref(0)
    const getAcumTotalByDetails = computed(() => {
        acumByDetails.value = 0
        form.value.reception_details.map((detail) => {
            acumByDetails.value += parseFloat(detail.rate) * parseInt(detail.quantity_partial);
            acumByDetails.value +=
                parseFloat(detail.price_additional) *
                parseInt(detail.time_additional);
        });
        return acumByDetails.value
    })

    const acumByProducts = ref(0)

    const getAcumByProducts = computed(() => {
        acumByProducts.value =0
        products.value.map(item => {
            acumByProducts.value += item.price * item.quantity
        })
        return acumByProducts.value
    })

    const getAcumByPayments = computed(() => {
        let acum = 0;
        form.value.payments.map(pago => {

            acum += pago.quantity
        })
        return acum
    })

    const verifyEqualPaymentAndAcum = computed(() => {

        return getAcumByPayments.value >= getAcumTotal.value
    })

    const getAcumTotal = computed(() => {
        return getAcumByProducts.value + getAcumTotalByDetails.value
    })
    const { show } = storeToRefs(reception);

    const setClient = (client_id) => {
        form.value.client_id = client_id;

    }
    const printInvoice = () => {
        console.log('preparando factura');

            let url = "/invoice/create";
            let data = {
                client_id: form.value.client_id,
                room_id: item.value.id,
                reception_details: form.value.reception_details,
                payments: form.value.payments,
                products: products.value,
                click_in_invoice : click_in_invoice.value,
                fiscal_machine_id: helper.caja_fiscal
            };
        console.log('data factura',data);

        axios
            .post(url, data)
            .then((res) => {
                console.log('facturado');

                if(click_in_invoice.value){
                console.log('imprimiendo factura');

                    let id = res.data.message.id;
                    window.open(`/invoice/printFiscal/${id}?chan=${chanchuyo.value}`);
                }
                if(!click_in_invoice.value){
                    let ventana = window.open("/client/reception-ticket?room_id=" + item.value.id).print();
                }

                show.value = false;
                location.reload();

                $("#exampleModal23").modal("hide");
            })
            .catch((err) => helper.getErrorRequest(err));
    };

    const openModal = () => {
        $("#exampleModal23").modal("show");
    };

    const isPrintable = (item) => {
        return item.attributes.status == "Sin Imprimir";
    };

    const isCancellable = (item) => {
        return item.attributes.status == "Impreso";
    };

    const printFiscalInvoice = (item, dev = false) => {
        let id = item.id;
        let url;
        console.log(item, dev);
        if (dev == false) {
            url = "/invoice/printFiscal/" + id;
        } else {
            url = "/invoice/printFiscal/" + id + "?isCancel=true";
        }
        window.open(url);
        //helper.getAll()
        location.reload();
    };

    const chanchuyo = ref(false)

    return {
        isPrintable,
        isCancellable,
        getClientFullName,
        showDetails,
        printFiscalInvoice,
        payment,
        addPayment,
        getDetails,
        details,
        deletePayment,
        form,
        getTotalByDetails,
        printInvoice,
        getAcumTotalByDetails,
        products,
        deleteProduct,
        addProduct,
        getAcumByProducts,
        getAcumTotal,
        click_in_invoice,
        setClient,
        verifyEqualPaymentAndAcum,
        getAcumByPayments,
        chanchuyo
    };
});
