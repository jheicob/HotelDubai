import { defineStore, storeToRefs } from "pinia";
import { HelperStore } from "@/HelperStore";

export const ocuppyRoomStore = defineStore('ocuppyRoomStore',() => {
    const helper = HelperStore()
    const {form} = storeToRefs(helper)

    const clearForm = () => {
        form.value = {
            document : '',
            first_name : '',
            last_name : '',
            phone : '',
            email : '',
            //
            room_id : '',
            date_in : '',
            observation : '',
            quantity_partial : '',
        }
    }

    const getClient = () => {
        let params = {
            document : form.value.document
        }
        axios
            .get('/client/get',{params})
            .then((response) => {
                console.log(response)
            })
            .catch((err) => helper.getErrorRequest(err))
        console.log(response);
    }

    return {
        clearForm,
        getClient
    }
})
