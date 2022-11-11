// import defineStore of pinia
import { defineStore, storeToRefs } from "pinia";
import axios from "axios";
import { ref, computed } from "vue";
import { HelperStore } from "../../HelperStore";
import { ocuppyRoomStore } from "./Modals/OcuppyRoomStore";
import { receptionStore } from "./Reception/ReceptionStore";
import dayjs from "dayjs";

export const RoomStore = defineStore("roomStore", () => {
    const OcuppyRoom = ocuppyRoomStore();
    const reception = receptionStore();
    const useHelper = HelperStore();
    useHelper.url = "room";

    const estate_type_id = ref("");
    const roomType = ref([]);
    const partialCost = ref([]);
    const roomStatus = ref([]);
    const room_type_id = ref("");
    const description = ref("");
    const rooms = ref([]);
    const btn_room_status_id = ref("");
    const { all, item } = storeToRefs(useHelper);
    const { customRequest } = useHelper;
    const getRooms = () => {
        useHelper.getAll();
    };

    const formatForm = () => {
        return {
            name: "",
            description: "",
            rate: "",
            partial_cost_id: "",
            room_status_id: "",
            estate_type_id: "",
            repair: "",
        };
    };

    const setForm = (item) => {
        room_type_id.value =
            item.relationships.partialCost.relationships.roomType.id;
        getPartialCost();
        formatRepair(item);
        return {
            id: item.id,
            name: item.attributes.name,
            description: item.attributes.description,
            rate: item.relationships.partialCost.attributes.rate,
            partial_cost_id: item.relationships.partialCost.id,
            room_status_id: item.relationships.roomStatus.id,
            estate_type_id: item.relationships.estateType?.id ?? "",
            repair: item.relationships.inRepair,
        };
    };

    const answer_repair = ref(false);
    const form_repair = ref({
        room_id: "",
        description: "",
        observation: "",
    });

    const formatRepair = (item) => {
        let repair = item.relationships.inRepair;
        form_repair.value.room_id = item.id;
        if (!repair) return;
        answer_repair.value = true;
        form_repair.value.description =
            item.relationships.inRepair.attributes.description;
        form_repair.value.observation =
            item.relationships.inRepair.attributes.observation;
    };

    const getRoomType = () => {
        var urlKeeps = "/configuracion/room-type/get";
        axios
            .get(urlKeeps)
            .then((response) => {
                roomType.value = response.data.data;
            })
            .catch((err) => {});
    };

    const getPartialCost = () => {
        partialCost.value = [];
        useHelper.form.partial_cost_id = "";
        let params = {
            room_type_id: room_type_id.value,
        };
        var urlKeeps = "/tarifas/partial-cost/get";
        axios
            .get(urlKeeps, { params })
            .then((response) => {
                partialCost.value = response.data.data;
            })
            .catch((err) => {});
    };

    const getRate = computed(() => {
        if (!useHelper.form.partial_cost_id) {
            return 0;
        }
        let one_partial_cost = partialCost.value.find(
            (cost) => cost.id === useHelper.form.partial_cost_id
        );
        return one_partial_cost.attributes.rate;
    });

    const showDetail = (room) => {
        item.value = room;
        $("#showDetail").modal("show");
    };

    const getRoomStatus = () => {
        var urlKeeps = "/configuracion/room-status/get";
        axios
            .get(urlKeeps, {
                data: {
                    room_type_id,
                },
            })
            .then((response) => {
                roomStatus.value = response.data.data;
            })
            .catch((err) => {});
    };

    const estateTypes = ref([]);
    const getEstateTypes = () => {
        var urlKeeps = "/configuracion/estate-type/get";
        axios
            .get(urlKeeps)
            .then((response) => {
                estateTypes.value = response.data.data;
            })
            .catch((err) => {});
    };

    const filterRoomsByStatus = (statusId = "") => {
        all.value = [];
        btn_room_status_id.value = statusId;
        let option = `room_status_id=${btn_room_status_id.value}&estate_type_id=${estate_type_id.value}`;
        useHelper.getAll(option);
        //         if(rooms.value.length == 0){
        //             rooms.value = all.value
        //         }
        //         if(rooms.value.length != all.value.length){
        //             all.value = rooms.value
        //         }
        //         if(statusId){
        //             all.value = all.value.filter ((item) => {
        // //                console.log(item);
        //                 if(statusId == 'culminar'){
        //                 }else
        //                 if(item.relationships.roomStatus.id == statusId) return true
        //             })
        //         }else{
        //             all.value = rooms.value
        //         }
    };
    const filterRoomsByEstateType = (statusId = "") => {
        all.value = [];

        estate_type_id.value = statusId;
        let option = `room_status_id=${btn_room_status_id.value}&estate_type_id=${estate_type_id.value}`;
        useHelper.getAll(option);
        // if (rooms.value.length == 0) {
        //     rooms.value = all.value;
        // }

        // if (rooms.value.length != all.value.length) {
        //     all.value = rooms.value;
        // }

        // if (statusId) {
        //     all.value = all.value.filter((item) => {
        //         //                console.log(item);
        //         if (item.relationships.estateType?.id == statusId) return true;
        //     });
        // } else {
        //     all.value = rooms.value;
        // }
    };
    const setRooms = async () => {
        await useHelper.getAll();
        rooms.value = all.value;
    };

    const ShowOcuppyButton = (item) => {
        return (
            useHelper.permiss.ocuppy &&
            item.relationships.roomStatus.attributes.name == "Disponible"
        );
    };
    const ShowFreeButton = (item) => {
        return (
            useHelper.permiss.free &&
            (item.relationships.roomStatus.attributes.name == "Ocupada" ||
                item.relationships.roomStatus.attributes.name == "Limpiando")
        );
    };
    const ShowExtendButton = (item) => {
        return (
            useHelper.permiss.extend &&
            item.relationships.roomStatus.attributes.name == "Ocupada"
        );
    };

    const ShowOccuppyModal = (item) => {
        useHelper.item = item;
        OcuppyRoom.clearForm();
        $("#showOcuppyRoom").modal("show");
    };

    const ShowCleanButton = (item) => {
        return (
            useHelper.permiss.clean &&
            item.relationships.roomStatus.attributes.name == "Ocupada"
        );
    };

    const FreeRoom = (item) => {
        if (item.relationships.roomStatus.attributes.name == "Ocupada") {
            console.log("comienza a facturar");
        } else if (
            item.relationships.roomStatus.attributes.name == "Limpiando"
        ) {
            changeStatusRoom(item.id, 4);
        }
    };

    const createFree = (item) => {
        console.log("habitacion Liberada");
    };

    const createExtend = (item) => {
        console.log("Habitación extendida");
    };

    const changeStatusRoom = (room_id, room_status_id) => {
        let url = `room/${room_id}/change-status`;
        let data = {
            room_status_id: room_status_id,
        };

        new Promise(customRequest(url, "post", data), getRooms());
    };

    const UpdateCleanRoom = (item) => {
        changeStatusRoom(item.id, 1);
    };
    const selectColor = (item, countdown) => {
        //console.log(item);
        let css = "";
        switch (item.relationships.roomStatus.attributes.name) {
            case "Ocupada":
                let hour = countdown.split(":")[0];
                let minutes = countdown.split(":")[1];
                css = hour == 0 && minutes < 15 ? "bg-warning" : "bg-dangerr";
                break;
            case "Disponible":
                css = "bg-greensea";
                break;
            case "Sucia":
                css = "bg-warningg";
                break;
            case "Mantenimiento":
                css = "bg-infoo";
                break;
        }
        return css;
    };

    const showPartialAndRate = (item) => {
        //    console.log(item)
        let rate = item.attributes.rate_current;
        let partial =
            item.relationships.partialCost.relationships.partialRate.attributes
                .name;

        return `${rate} (${partial})`;
    };

    const { show, updated_reception } = storeToRefs(reception);
    const showCreateReception = (room) => {
        //  console.log(item)
        if (!useHelper.permiss.ocuppy) {
            return;
        }
        if (
            room.relationships.roomStatus.id != 2 &&
            room.relationships.roomStatus.id != 4
        ) {
            return;
        }
        show.value = true;
        item.value = room;

        if (room.relationships.receptionActive != null) {
            //console.log('item')
            updated_reception.value = true;
            OcuppyRoom.clearForm(room);
        } else {
            updated_reception.value = false;
            //console.log('no useStore.item')
            OcuppyRoom.clearForm();
        }
    };

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
        filterRoomsByStatus,
        getEstateTypes,
        estateTypes,
        filterRoomsByEstateType,
        estate_type_id,
        answer_repair,
        form_repair,
    };
});
