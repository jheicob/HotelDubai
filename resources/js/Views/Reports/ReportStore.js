import axios from "axios";
import { defineStore } from "pinia";
import {ref} from "vue";
export const ReportStore = defineStore("ReportStore",() => {
    const type_report = ref('')
    const url = ref('')
    const form =ref({
        room_type_id: [],
        estate_type_id: [],
        date_start: '',
        date_end: ''
    })

    const input_views = ref({
        range_dates:    true,
        room_type_id:   true,
        estate_type_id: true,
    })
    const openModal = (type) => {
        type_report.value = type

        switch(type){
            case 'Clientes':
                url.value = '/client/report?'
                input_views.value.room_type_id = false
                input_views.value.range_dates = true
                input_views.value.estate_type_id = false
                break
            case 'Tipo Habitaciones':
                url.value = '/room/report/room-type?'
                input_views.value.room_type_id = true
                input_views.value.range_dates = true
                input_views.value.estate_type_id = true
                break
            case 'Habitaciones':
                url.value = '/room/report?'
                input_views.value.room_type_id = true
                input_views.value.range_dates = true
                input_views.value.estate_type_id = true
                break
            case 'Recepciones':
                url.value = '/room/report/reception?'
                input_views.value.room_type_id = true
                input_views.value.range_dates = true
                input_views.value.estate_type_id = true
                break;
            default:
                breaK;
        }
        $('#reportModal').modal('show');
    }

    const abrirReporte = () => {
        let room_types = form.value.room_type_id.map(item => {
            return `room_type_id[]=${item.id}`
        })
        let estate_types = form.value.estate_type_id.map(item => {
            return `estate_type_id[]=${item.id}`
        })
        let dates = `date_start=${form.value.date_start}&date_end=${form.value.date_end}`

        let new_url = `${room_types}&${estate_types}&${dates}`
        window.open(url.value+new_url)
        location.reload()
    }

    const closeModal = () => {
        $('#reportModal').modal('hide');
    }
    const estateTypes = ref([])

    const getEstateTypes = () => {
        axios
            .get('configuracion/estate-type/get')
            .then(res => {
                estateTypes.value = res.data.data
            })
    }

    const setRoomTypes = (items) => {
        return items.map(item => ({
            id: item.id,
            name: item.attributes.name
        }))
    }

    return {
        openModal,
        type_report,
        abrirReporte,
        getEstateTypes,
        url,
        estateTypes,
        setRoomTypes,
        form,
        input_views,
        closeModal
    }
});
