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
        reception_details: {
            id: "",
            time_additional: "",
            price_additional: "",
        },
    });

    const generateInvoice = (room) => {
        let details = room.relationships.receptionActive.relationships.details;
        /*    for(let detail in details){
        form.value[]
    }*/
    };

    const { show } = storeToRefs(reception);
    const printInvoice = (igtf) => {
        let url = "invoice/create";
        let data = {
            client_id:
                helper.item.relationships.receptionActive.relationships.client
                    .id,
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
        return item.attributes.status == 'Sin Imprimir'
    }

    const isCancellable = (item) => {
        return item.attributes.status == 'Impreso'
    }

        const printFiscalInvoice = (item, dev = false) => {
            let id = item.id
            let url;
console.log(item,dev)
            if(dev == false){
                url = "/invoice/printFiscal/" + id
            }else{
                url = "/invoice/printFiscal/" + id + '?isCancel=true'
            }
                window.open(url);
                //helper.getAll()
           location.reload();
        }
    return {
        isPrintable,
        isCancellable,
        getClientFullName,
        showDetails,
        printFiscalInvoice,
        getDetails,
        details,
        form,
        printInvoice,
    };
});
