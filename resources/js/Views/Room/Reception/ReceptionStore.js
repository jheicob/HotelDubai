import {defineStore} from 'pinia'
import {ref} from 'vue'
import dayjs from 'dayjs'
export const receptionStore = defineStore('ReceptionStore',() => {
    const show = ref(false);
    const updated_reception = ref(false);
    const hiddenReception = () => {
        show.value = false
    }

    const isOcupped = (item) => {
  //      console.log('ocupped',item)
//        if(!item) return false;
        return item.relationships.roomStatus.attributes.name == 'Ocupada'
    }

    return {
        show,
        updated_reception,
        hiddenReception,
        isOcupped
    }
})
