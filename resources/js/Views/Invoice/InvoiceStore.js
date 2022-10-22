import { defineStore } from "pinia";
import { ref , computed} from "vue";
import axios from "axios";
import { HelperStore } from "@/HelperStore";

export const InvoiceStore = defineStore("InvoiceStore", () => {
    
    const helper = HelperStore();

    helper.url = 'invoice'

    const getClientFullName = (client) => {
        return client.attributes.first_name + ' ' + client.attributes.last_name
    };
    
    const showDetails = (item) => {
        helper.item = item
        $("#exampleModal2").modal("show");
    }

    const getDetails = ()=> {
        let details = helper.item;
        if(!details) return []

        return details.relationships.details
    }
    return {
        getClientFullName,
        showDetails,
        getDetails
   
 }
})
