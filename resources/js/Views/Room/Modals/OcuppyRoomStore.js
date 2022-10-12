import { defineStore, storeToRefs } from "pinia";
import { HelperStore } from "@/HelperStore";
import {computed, ref} from 'vue'
import moment from 'moment'
import { RoomStore } from "../RoomStore";

export const ocuppyRoomStore = defineStore('ocuppyRoomStore',() => {
    const helper = HelperStore()
    const useRoom = RoomStore()
    const {form,item} = storeToRefs(helper)
    const client_exist = ref(false)
    const type_documents = ref([])
    const client = ref({})
    const date = ref(moment().format('YYYY-DD-MM'))
    const hour = ref(moment().format('H:mm'))

    const clearForm = () => {
        form.value = {
            client_id: null,
            document : '',
            type_document_id: '',
            first_name : '',
            last_name : '',
            phone : '',
            email : '',
            //
            room_id : '',
            date_in : setDate.value,
            observation : '',
            quantity_partial : 1,
        }
    }

    const setDate = computed( () => {
        return `${date.value} ${hour.value}`
    })

    const getClient = () => {
        client_exist.value = false
        let params = {
            document : form.value.document
        }
        axios
            .get('/client/get',{params})
            .then((response) => {
                let res = response.data.data
                if(res.length > 0){
                    res = res[0]
                    console.log(res)
                    form.value.client_id = res.id
                    form.value.document = res.attributes.document;
                    form.value.type_document_id = res.attributes.type_document_id
                    form.value.first_name = res.attributes.first_name;
                    form.value.last_name = res.attributes.last_name;
                    form.value.phone = res.attributes.phone;
                    form.value.email = res.attributes.email;
                }else{
                    form.value.client_id= null
                    form.value.first_name = ''
                    form.value.last_name = ''
                    form.value.phone = ''
                    form.value.email = ''
                }
                client_exist.value = true
            })
            .catch((err) => helper.getErrorRequest(err))
    }

    const assigRoom = () => {
        let data = {
            client_id : form.value.client_id,
            room_id : item.value.id,
            date_in : form.value.date_in,
            observation : form.value.observation,
            quantity_partial : form.value.quantity_partial,
        }
        axios
            .post('/client/assigned_room',data)
            .then((response) => {
                //
                $("#showOcuppyRoom").modal("hide")
                clearForm()
                useRoom.getRooms();

            })
            .catch((err) => helper.getErrorRequest(err))
    }
    const storeAssignedRoom = () =>{
        if(!form.value.client_id){
            storeClient()
            return;
        }
        assigRoom()
    }
    const storeClient = () => {
        let data = {
            document : form.value.document,
            type_document_id : form.value.type_document_id,
            first_name : form.value.first_name,
            last_name : form.value.last_name,
            phone : form.value.phone,
            email : form.value.email,
        }
        axios
            .post('/client/create',data)
            .then((response) => {
                form.value.client_id = response.data.data.id
                assigRoom()
            })
            .catch((err) => helper.getErrorRequest(err))
    }

    const getTypeDocuments = () => {
        axios
            .get('/type-document/get')
            .then((response) => {
                type_documents.value = response.data.data
            })
            .catch((err) => helper.getErrorRequest(err))
    }

    return {
        clearForm,
        date,
        hour,
        getClient,
        storeAssignedRoom,
        client_exist,
        getTypeDocuments,
        type_documents
    }
})
