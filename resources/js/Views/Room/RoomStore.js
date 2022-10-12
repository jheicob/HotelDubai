// import defineStore of pinia
import { defineStore,storeToRefs } from 'pinia'
import axios from "axios";
import {ref,computed} from 'vue'
import { HelperStore } from '../../HelperStore';
import { ocuppyRoomStore } from './Modals/OcuppyRoomStore';

export const RoomStore = defineStore('roomStore',() => {
    const OcuppyRoom = ocuppyRoomStore()

    const useHelper = HelperStore()
    useHelper.url = 'room'

    const roomType = ref([])
    const partialCost = ref([])
    const roomStatus = ref([])
    const room_type_id = ref('')
    const description = ref('');
    const rooms = ref([]);
    const {all,item} = storeToRefs(useHelper)

    const getRooms = () => {
        useHelper.getAll();
    }

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

    const showDetail = (room) => {
        item.value = room
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

    const ShowOcuppyButton = (item) => {
        return (
            useHelper.permiss.ocuppy &&
            item.relationships.roomStatus.attributes.name == 'Disponible')
    }
    const ShowFreeButton = (item) => {
        return (
            useHelper.permiss.free
            && (
                item.relationships.roomStatus.attributes.name == 'Ocupada'
                || item.relationships.roomStatus.attributes.name == 'Limpiando'
                )
            )
    }
    const ShowExtendButton = (item) => {
        return (
            useHelper.permiss.extend
            && item.relationships.roomStatus.attributes.name == 'Ocupada'
            )
    }

    const ShowOccuppyModal = (item) => {
        useHelper.item = item
        OcuppyRoom.clearForm()
        $("#showOcuppyRoom").modal("show");

    }

    const createFree = (item) => {
        console.log('habitacion Liberada')
    }

    const createExtend = (item) => {
        console.log('Habitación extendida')
    }


    return {
        getRooms,
        ShowOccuppyModal,
        ShowOcuppyButton,
        ShowExtendButton,
        ShowFreeButton,
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
