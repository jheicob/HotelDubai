import { defineStore } from 'pinia'
import { ref } from 'vue'

export const HelperStore = defineStore('HelperStore',() => {
    const desactiveButton = ref(false)
    const permiss = ref({
        create:false,
        deletet:false,
        updated: false,
    })
    return {
        desactiveButton,
        permiss
    }
})
