import { defineStore } from "pinia";
import {ref} from "vue";
import axios from "axios";

export const NotificationStore = defineStore('NotificationsStore', () => {
    const notification = ref([])


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
        event,
        getNotifications,
        removeNotification


    }
})