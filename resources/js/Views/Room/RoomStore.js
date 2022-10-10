// import defineStore of pinia
import { defineStore } from 'pinia'
import axios from "axios";
import {ref,computed} from 'vue'
import { HelperStore } from '../../HelperStore';

export const RoomStore = defineStore('roomStore',() => {

    const useHelper = HelperStore()

    useHelper.url = 'room'

    const roomType = ref([])
    const partialCost = ref([])
    const roomStatus = ref([])
    const room_type_id = ref('')

    const formatForm = () => {
        return {
            name: '',
            description: "",
            rate: "",
            partial_cost_id: "",
            room_status_id: "",
        }
    }

    const setForm = (item) => {
        room_type_id.value = item.relationships.partialCost.relationships.roomType.id
        getPartialCost()

        return {
            id: item.id,
            name: item.attributes.name,
            description: item.attributes.description,
            rate: item.relationships.partialCost.attributes.rate,
            partial_cost_id: item.relationships.partialCost.id,
            room_status_id: item.relationships.roomStatus.id,
        }
    }

    const getRoomType = () => {
        var urlKeeps = "/configuracion/room-type/get";
        axios
            .get(urlKeeps)
            .then((response) => {
                roomType.value = response.data.data;
            })
            .catch((err) => {});
    }

    const getPartialCost = () => {
        partialCost.value = [];
        useHelper.form.partial_cost_id = ''
        let params = {
            room_type_id : room_type_id.value
        }
        var urlKeeps = "/tarifas/partial-cost/get";
        axios
            .get(urlKeeps,{params})
            .then((response) => {
                partialCost.value = response.data.data;
            })
            .catch((err) => {});
    }

    const getRate = computed(()=> {
        if(!useHelper.form.partial_cost_id){
            return 0;
        }
        let one_partial_cost = partialCost.value.find(cost => cost.id === useHelper.form.partial_cost_id)
        return one_partial_cost.attributes.rate
    })

    const getRoomStatus = () => {
        var urlKeeps = "/configuracion/room-status/get";
        axios
            .get(urlKeeps,{
                data:{
                    room_type_id
                }
            })
            .then((response) => {
                roomStatus.value = response.data.data;
            })
            .catch((err) => {});
    }


    return {
        formatForm,
        setForm,
        getRoomType,
        getPartialCost,
        getRoomStatus,
        roomStatus,
        roomType,
        partialCost,
        room_type_id,
        getRate
    }
})
