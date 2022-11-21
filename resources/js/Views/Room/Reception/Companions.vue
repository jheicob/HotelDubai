<template>
    <button
        class="btn btn-success"
        @click="openCompanionsModal"
        type="button"
        >
        Acompañantes
    </button>
    <ModalComponent idModal="companions" title footer size="lg">
        <template #title>
            <h3>Acompañantes</h3>
        </template>

        <table class="table text-center">
            <thead>
                <tr>
                    <th>Tipo Documento</th>
                    <th>Cedula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Tipo Huesped</th>
                    <th>Accion</th>
                </tr>
            </thead>
                <tbody>
                    <tr v-for="(item,i) in companions" :key="i">
                        <td>{{getNameTypeDocument(item.type_document_id).attributes.name }}</td>
                        <td>{{item.dni}}</td>
                        <td>{{item.first_name}}</td>
                        <td>{{item.last_name}}</td>
                        <td>{{getNameExtraGuest(item.extra_guest_id).attributes.name }}</td>
                        <td> <i
                            v-if="item.id == ''"
                            class="fas fa-minus"
                            style="cursor: pointer"
                            @click="deleteCompanion(i)"
                              >
                        </i></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-select" v-model="new_companion.type_document_id">
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
                            </select>
                        </td>
                        <td>
                            <input
                            type="text"
                            class="form-control"
                            v-model="new_companion.dni"
                            @blur="getClient"
                            />
                        </td>
                        <td>
                            <input
                            type="text"
                            class="form-control"
                            v-model="new_companion.first_name"
                            />
                        </td>
                        <td>
                            <input
                                type="text"
                                class="form-control"
                                v-model="new_companion.last_name"
                                />
                        </td>
                        <td>
                            <select class="form-select"  v-model="new_companion.extra_guest_id">
                                <option value="">
                                    Seleccione...
                                </option>
                                <option
                                    v-for="(
                                        item, i
                                    ) in guests.all"
                                    :key="i"
                                    :value="
                                        item.id
                                    "
                                >
                                    {{
                                        item
                                            .attributes
                                            .name
                                    }}
                                </option>
                            </select>

                        </td>
                        <td>
                            <i
                                class="fas fa-plus"
                                style="cursor: pointer"
                                @click="addCompanion"
                            >
                            </i>
                        </td>
                    </tr>
                </tbody>
        </table>

        <template #footer>
                    <button
                        class="btn btn-danger col-2"
                        @click="closeCompanionsModal(false)"
                        type="button"
                    >
                    Cerrar
                    </button>
                    <button
                        class="btn btn-primary col-2"
                        @click="closeCompanionsModal(true)"
                        type="button"
                    >
                    Guardar
                    </button>
        </template>
    </ModalComponent>
</template>
<script setup>
    import ModalComponent from "@/components/ModalComponent.vue"
    import { HelperStore } from "../../../HelperStore";
    import { InvoiceStore } from "../../Invoice/InvoiceStore";
    import { ref ,onMounted} from "vue";
    import { ExtraGuestStore } from "../../ExtraGuest/ExtraGuestStore";
    import { ocuppyRoomStore } from "../Modals/OcuppyRoomStore";
    import { storeToRefs } from "pinia";
    import {CompanionStore} from './CompanionsStore'

    const ocuppy = ocuppyRoomStore()
    const guests = ExtraGuestStore()
    const helper = HelperStore()
    const invoice = InvoiceStore()
    const store = CompanionStore()

    const {companions} = storeToRefs(store)
    const {products} = storeToRefs(invoice)
    const new_companion = ref({
        id:'',
        client_id:'',
        dni: '',
        type_document_id: '',
        first_name: "",
        last_name: "",
        extra_guest_id: ""
    })


    const addCompanion = () => {
        if(new_companion.value.client_id == ''){
            let data = {
                document: new_companion.value.dni,
                type_document_id: new_companion.value.type_document_id,
                first_name: new_companion.value.first_name,
                last_name: new_companion.value.last_name,
            };
            axios
                .post("/client/create", data)
                .then((response) => {
                    new_companion.value.client_id = response.data.data.id;
                    companions.value.push(new_companion.value);
                    new_companion.value = {
                        client_id:'',
                        dni: '',
                        type_document_id: '',
                        first_name: "",
                        last_name: "",
                        extra_guest_id: ""
                    }
                })
                .catch((err) => helper.getErrorRequest(err));
        }else{
            companions.value.push(new_companion.value);
            new_companion.value = {
                id:'',
                client_id:'',
                dni: '',
                type_document_id: '',
                first_name: "",
                last_name: "",
                extra_guest_id: ""
            }
        }
    }
    const deleteCompanion = (i) => {
        companions.value.splice(i,1)
    }

    const openCompanionsModal = () => {
        setCompanions()
        $('#companions').modal('show')
    }

    const {setCompanions, getNameExtraGuest,
        getNameTypeDocument,setGuestsInProduct} = store

    const closeCompanionsModal = (save = false) => {
        if(!save){
            companions.value = []
        }else{
            setGuestsInProduct()
        }
        $('#companions').modal('hide')
    }


    const getClient = () => {
        let params = {
            document: new_companion.value.dni,
        };
        axios
            .get("/client/get", { params })
            .then((response) => {
                let res = response.data.data;
                if (res.length > 0) {
                    res = res[0]
                    new_companion.value.client_id = res.id;
                    new_companion.value.dni = res.attributes.document;
                    new_companion.value.type_document_id = res.attributes.type_document_id;
                    new_companion.value.first_name = res.attributes.first_name;
                    new_companion.value.last_name = res.attributes.last_name;
                }
            })
            .catch((err) => helper.getErrorRequest(err))
            ;
    };

    onMounted(() => {
        guests.getRoomTypes() // get extra guests

    })
</script>
