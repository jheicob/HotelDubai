import {defineStore} from 'pinia'
import {ref} from 'vue'
import dayjs from 'dayjs'
export const receptionStore = defineStore('ReceptionStore',() => {
    const show = ref(false);
    const hiddenReception = () => {
        show.value = false
    }

    const isOcupped = (item) => {
        return item.relationships.roomStatus.attributes.name == 'Ocupada'
    }

    return {
        show,
        hiddenReception,
        isOcupped
    }
})
