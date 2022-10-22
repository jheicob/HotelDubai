// import defineStore of pinia
import { defineStore,storeToRefs } from 'pinia'
import axios from "axios";
import {ref,computed} from 'vue'
import { HelperStore } from '../../HelperStore';
import { ocuppyRoomStore } from './Modals/OcuppyRoomStore';
import {receptionStore} from './Reception/ReceptionStore'

export const RoomStore = defineStore('roomStore',() => {
    const OcuppyRoom = ocuppyRoomStore()
    const reception = receptionStore();
    const useHelper = HelperStore()
    useHelper.url = 'room'

    const roomType = ref([])
    const partialCost = ref([])
    const roomStatus = ref([])
    const room_type_id = ref('')
    const description = ref('');
    const rooms = ref([]);
    const {all,item} = storeToRefs(useHelper)
    const {customRequest} = useHelper
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
//                console.log(item);
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

    const ShowCleanButton = (item) => {
        return (
            useHelper.permiss.clean
            && item.relationships.roomStatus.attributes.name == 'Ocupada'
            )
    }

    const FreeRoom = (item) => {
        if(item.relationships.roomStatus.attributes.name == 'Ocupada'){
            console.log('comienza a facturar')
        }else
        if(item.relationships.roomStatus.attributes.name == 'Limpiando'){
            changeStatusRoom(item.id,4)
        }
    }

    const createFree = (item) => {
        console.log('habitacion Liberada')
    }

    const createExtend = (item) => {
        console.log('Habitación extendida')
    }

    const changeStatusRoom = (room_id,room_status_id) => {
        let url = `room/${room_id}/change-status`
        let data = {
            room_status_id : room_status_id
        }

        new Promise(customRequest(url,'post',data),getRooms())

    }

    const UpdateCleanRoom = (item) => {
        changeStatusRoom(item.id,1)
    }
const selectColor = (item) => {
//console.log(item);
    let css = ''
    switch (item.relationships.roomStatus.attributes.name){
        case 'Ocupada':
           css = 'bg-dangerr';
            break;
        case 'Disponible':
            css = 'bg-greensea'
            break
        case 'Limpiando':
            css = 'bg-warningg';
            break;
        case 'Reparación':
            css = 'bg-infoo';
            break;
    }
    return css;
}

const showPartialAndRate = (item)=>{
//    console.log(item)
    let rate = item.relationships.partialCost.attributes.rate
    let partial = item.relationships.partialCost.relationships.partialRate.attributes.name

    return `${rate} (${partial})`
}

const {show,updated_reception} = storeToRefs(reception)
const showCreateReception = (room) => {
  //  console.log(item)
    show.value = true;
    item.value = room
    if(room.relationships.receptionActive != null){
//console.log('item')
        updated_reception.value = true
    OcuppyRoom.clearForm(room)
    }else{

        updated_reception.value = false
//console.log('no item')
    OcuppyRoom.clearForm()
    }
    
    
}

    return {
        showCreateReception,
        showPartialAndRate,
        selectColor,
        FreeRoom,
        UpdateCleanRoom,
        getRooms,
        ShowCleanButton,
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
