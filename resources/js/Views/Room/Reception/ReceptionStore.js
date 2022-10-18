import {defineStore} from 'pinia'
import {ref} from 'vue'

export const receptionStore = defineStore('ReceptionStore',() => {
    const show = ref(false);

    const hiddenReception = () => {
        show.value = false
    }
    return {
        show,
        hiddenReception,
    }
})
