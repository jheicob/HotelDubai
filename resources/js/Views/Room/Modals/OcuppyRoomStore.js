import { defineStore, storeToRefs } from "pinia";
import { HelperStore } from "@/HelperStore";
import { computed, ref } from "vue";
import moment from "moment";
import { RoomStore } from "../RoomStore";
import { receptionStore } from "../Reception/ReceptionStore";
import dayjs from "dayjs";
import { InvoiceStore } from "../../Invoice/InvoiceStore";
import { CompanionStore } from "../Reception/CompanionsStore";

export const ocuppyRoomStore = defineStore("ocuppyRoomStore", () => {
    const helper = HelperStore();
    const companion = CompanionStore()
    const useRoom = RoomStore();
    const reception = receptionStore();
    const invoice = InvoiceStore();
    const { form, item } = storeToRefs(helper);
    const client_exist = ref(false);
    const type_documents = ref([]);
    const client = ref({});
    const date = ref(moment().format("YYYY-MM-DD"));
    const hour = ref(moment().format("HH:mm"));
    const click_in_invoice = ref(false);
    const reception_update = ref(false);

    const clearForm = (update = false) => {
        if (update) {
            reception_update.value = true;
            client_exist.value = true;
            date.value = moment(
                update.relationships.receptionActive.attributes.date_out
            ).format("YYYY-MM-DD");
            hour.value = moment(
                update.relationships.receptionActive.attributes.date_out
            ).format("HH:mm");

            form.value = {
                client_id:
                    update.relationships.receptionActive.attributes.client_id,
                document:
                    update.relationships.receptionActive.relationships.client
                        .attributes.document,
                type_document_id:
                    update.relationships.receptionActive.relationships.client
                        .attributes.type_document_id,
                first_name:
                    update.relationships.receptionActive.relationships.client
                        .attributes.first_name,
                last_name:
                    update.relationships.receptionActive.relationships.client
                        .attributes.last_name,
                phone: update.relationships.receptionActive.relationships.client
                    .attributes.phone,
                email: update.relationships.receptionActive.relationships.client
                    .attributes.email,
                //
                room_id: update.id,
                date_in:
                    update.relationships.receptionActive.attributes.date_in,
                observation:
                    update.relationships.receptionActive.attributes.observation,
                quantity_partial: 1,
                ticket_op: "Tarjeta",
            };
        } else {
            _;
            form.value = {
                client_id: null,
                document: "",
                type_document_id: "",
                first_name: "",
                last_name: "",
                phone: "",
                email: "",
                //
                room_id: "",
                date_in: setDate.value,
                observation: "",
                ticket_op: "Tarjeta",
                quantity_partial: 1,
            };
        }
    };

    const setDate = computed(() => {
        return `${date.value} ${hour.value}`;
    });

    const getClient = () => {
        client_exist.value = false;
        let params = {
            document: form.value.document,
        };
        axios
            .get("/client/get", { params })
            .then((response) => {
                let res = response.data.data;
                if (res.length > 0) {
                    res = res[0];
                    console.log(res);
                    form.value.client_id = res.id;
                    form.value.document = res.attributes.document;
                    form.value.type_document_id =
                        res.attributes.type_document_id;
                    form.value.first_name = res.attributes.first_name;
                    form.value.last_name = res.attributes.last_name;
                    form.value.phone = res.attributes.phone;
                    form.value.email = res.attributes.email;
                } else {
                    form.value.client_id = null;
                    form.value.first_name = "";
                    form.value.last_name = "";
                    form.value.phone = "";
                    form.value.email = "";
                }
                client_exist.value = true;
            })
            .catch((err) => helper.getErrorRequest(err));
    };

    const { show } = storeToRefs(reception);

    const assigRoom = () => {
        let data = {
            client_id: form.value.client_id,
            room_id: item.value.id,
            date_in: form.value.date_in,
            observation: form.value.observation,
            quantity_partial: form.value.quantity_partial,
            ticket_op: form.value.ticket_op,

            companions:companion.companions

        };
        axios
            .post("/client/assigned_room", data)
            .then((response) => {
                //
                $("#showOcuppyRoom").modal("hide");
                invoice.setClient(form.value.client_id)
                show.value = false;
                if(!click_in_invoice.value){
                    invoice.printInvoice()
                    // let ventana = window.open("/client/reception-ticket?room_id=" + item.value.id).print();
                }

            })
            .then(() => {
                useRoom.getRooms();
                clearForm();
                // location.reload();

            })
            .catch((err) => helper.getErrorRequest(err));
    };

    const storeAssignedRoom = () => {
        if (!form.value.client_id) {
            storeClient();
            return;
        }
        assigRoom();
    };
    const storeClient = () => {
        let data = {
            document: form.value.document,
            type_document_id: form.value.type_document_id,
            first_name: form.value.first_name,
            last_name: form.value.last_name,
            phone: form.value.phone,
            email: form.value.email,
        };
        axios
            .post("/client/create", data)
            .then((response) => {
                form.value.client_id = response.data.data.id;
                assigRoom();
            })
            .catch((err) => helper.getErrorRequest(err));
    };

    const getTypeDocuments = () => {
        axios
            .get("/type-document/get")
            .then((response) => {
                type_documents.value = response.data.data;
            })
            .catch((err) => helper.geterrorrequest(err));
    };

    const getReceptionDetailByItem = (item) => {
        return item.relationships?.receptionActive.details ?? [];
    };

    const products = ref([])

    const click_in_bodegon = ref(false)
    const getProducts = () => {

        let url,desc,type = ''
        if(click_in_bodegon.value){
            url = '/invoice/Product/get'
            type = 'Product'
        }else{
            url = "/configuracion/ExtraGuest/get"
            desc = 'huesped Extra'
            type = 'ExtraGuest'
        }
    axios
            .get(url)
            .then((response) => {
                products.value = response.data.data.map((item) => {
                    let description = item.attributes?.description ?? desc
                    let price = 0
                    if(click_in_bodegon.value){
                        price = item.attributes.sale_price
                    }else{
                        price = item.attributes.rate
                    }
                    return {
                        id: item.id,
                        name: item.attributes.name,
                        type: type,
                        description: description,
                        price: price,
                        quantity: 0
                    }
                });
                if(!click_in_bodegon.value){

                    products.value.push({
                        id: 0,
                        name: 'Otro',
                        type: '',
                        description: '',
                        price: 0,
                        quantity: 0
                    })
                }

            })
            .catch((err) => helper.geterrorrequest(err));

    }

const product = ref({
    id: '',
    name: '',
    description: '',
    price: 0,
    quantity: 0
})

const clearProduct = () => {
    product.value = {
    id: '',
    name: '',
    description: '',
    price: 0,
    quantity: 0
    }
}

const setProduct = (id) => {
    product.value = products.map(item => item.id == id)

}

    return {
        product,
        clearProduct,
        setProduct,
        products,
        getProducts,
        getReceptionDetailByItem,
        clearForm,
        date,
        hour,
        getClient,
        storeAssignedRoom,
        client_exist,
        getTypeDocuments,
        type_documents,
        click_in_invoice,
        click_in_bodegon
    };
});
