// import defineStore of pinia
import { defineStore,storeToRefs } from 'pinia'
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
    const description = ref('');
    const rooms = ref([]);

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

    const showDetail = (item) => {
        description.value = item.attributes.description
		$("#showDetail").modal("show");
    }

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

    const {all} = storeToRefs(useHelper)
    const filterRoomsByStatus = (statusId = null) => {
        if(rooms.value.length == 0){
            rooms.value = all.value
        }

        if(rooms.value.length != all.value.length){
            all.value = rooms.value
        }

        if(statusId){
            all.value = all.value.filter ((item) => {
                console.log(item);
                if(item.relationships.roomStatus.id == statusId) return true
            })
        }else{
            all.value = rooms.value
        }
    }

    const setRooms = async () => {
        await useHelper.getAll()
        rooms.value = all.value
    }


    return {
        setRooms,
        formatForm,
        setForm,
        getRoomType,
        getPartialCost,
        getRoomStatus,
        roomStatus,
        roomType,
        partialCost,
        room_type_id,
        getRate,
        showDetail,
        description,
        rooms,
        filterRoomsByStatus
    }
})
