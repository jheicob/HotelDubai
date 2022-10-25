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
    });

    const generateInvoice = (room) => {
        let details = room.relationships.receptionActive.relationships.details;
        /*    for(let detail in details){
        form.value[]
    }*/
    };

    const getTotalByDetails = (position) => {
        let item = form.value.reception_details[position];

        let sum = 0;

        sum += parseFloat(item.rate) * parseInt(item.quantity_partial);
        sum +=
            parseFloat(item.price_additional) * parseInt(item.time_additional);

        return sum;
    };

    const getAcumTotalByDetails = () => {
        let sum = 0;

        form.value.reception_details.map((detail) => {
            sum += parseFloat(detail.rate) * parseInt(detail.quantity_partial);
            sum +=
                parseFloat(detail.price_additional) *
                parseInt(detail.time_additional);
        });
        return sum
    };
    const { show } = storeToRefs(reception);

    const printInvoice = (igtf) => {
        let url = "invoice/create";
        let data = {
            client_id:
                helper.item.relationships.receptionActive.relationships.client
                    .id,
            reception_details: form.value.reception_details,
            payments: form.value.payments,
        };
        axios
            .post(url, data)
            .then((res) => {
                let id = res.data.message.id;
                window.open("/invoice/printFiscal/" + id);
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
getAcumTotalByDetails 
    };
});
