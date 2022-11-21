import { defineStore, storeToRefs } from "pinia";
    import { InvoiceStore } from "../../Invoice/InvoiceStore";
import {ref} from 'vue'
    import { ocuppyRoomStore } from "../Modals/OcuppyRoomStore";
    import { ExtraGuestStore } from "../../ExtraGuest/ExtraGuestStore";
    import {HelperStore} from "@/HelperStore"
export const CompanionStore = defineStore('CompanionStore',() => {
    const invoice = InvoiceStore()
    const ocuppy = ocuppyRoomStore()
    const guests = ExtraGuestStore()

    const companions = ref([])
    const helper = HelperStore()
    const {products} = storeToRefs(invoice)

    const groupByExtraGuest = () => {
        let groups = [];

        companions.value.map(item => {
            groups[item.extra_guest_id]
        })
    }

    const setCompanions = () => {
        if(!helper.item.relationships.receptionActive?.relationships.companions){
            return;
        }
        companions.value = helper.item.relationships.receptionActive?.relationships.companions.map(cp => {
            return {
                id:cp.id,
                client_id: cp.attributes.client_id,
                dni: cp.relationships.client.attributes.document,
                type_document_id: cp.relationships.client.attributes.type_document_id,
                first_name: cp.relationships.client.attributes.first_name,
                last_name: cp.relationships.client.attributes.last_name,
                extra_guest_id: cp.attributes.extra_guest_id
            }
        })

    }


    const getNameTypeDocument = (type_document_id) => {
        return ocuppy.type_documents.find(item => (item.id == type_document_id))
    }

    const getNameExtraGuest = (extra_guest_id) => {
        return guests.all.find(item => (item.id == extra_guest_id))
    }


    const setGuestsInProduct = () => {
        setCompanions()
        products.value =companions.value.map(companion => {
                return {
                id: getNameExtraGuest(companion.extra_guest_id).id,
                description: getNameExtraGuest(companion.extra_guest_id).attributes.name,
                name: 'huesped Extra',
                type: 'ExtraGuest',
                price: getNameExtraGuest(companion.extra_guest_id).attributes.rate,
                quantity: 1,
                block:true
            }
        })
    }
    return {
        companions,
        setGuestsInProduct,
       setCompanions ,
        getNameExtraGuest,
        getNameTypeDocument
    }
})
