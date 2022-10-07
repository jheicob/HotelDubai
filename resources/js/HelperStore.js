import { defineStore } from 'pinia'
import { ref } from 'vue'

export const HelperStore = defineStore('HelperStore',() => {
    const desactiveButton = ref(false)

    return {
        desactiveButton
    }
})
