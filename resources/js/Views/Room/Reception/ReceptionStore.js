import {defineStore} from 'pinia'
import {ref} from 'vue'
import dayjs from 'dayjs'
import {HelperStore} from '@/HelperStore'
export const receptionStore = defineStore('ReceptionStore',() => {
    const show = ref(false);
    const helper = HelperStore();

    const updated_reception = ref(false);
    const hiddenReception = () => {
        show.value = false
    }

    const isOcupped = (item) => {
  //      console.log('ocupped',item)
//        if(!item) return false;
        return item.relationships.roomStatus.attributes.name == 'Ocupada'
    }

    async function cancelUse(item){
        let client_id = item.relationships.receptionActive.relationships.client.id
        let url = 'client/'+client_id+'/cancel-use'
        await helper.customRequest(url,'get');
        location.reload()
    }
    return {
        cancelUse,
        show,
        updated_reception,
        hiddenReception,
        isOcupped
    }
})
