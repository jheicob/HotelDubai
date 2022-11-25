import { defineStore } from "pinia";
import {ref} from "vue";
import axios from "axios";

export const NotificationStore = defineStore('NotificationsStore', () => {
    const notification = ref([])
    const update_rooms = ref(false);
    const cont_rooms = ref(0)

    const getNotifications = () => {
        axios.get('/notifications')
                   .then(res => {
                    notification.value = res.data;
                   })
    }

    const removeNotification = (id) => {
        axios.put(`/notifications/${id}`).then(res => {
            getNotifications()
        })
    }
    return {
        notification,
        getNotifications,
        removeNotification,
        update_rooms,
        cont_rooms,
    }
})
