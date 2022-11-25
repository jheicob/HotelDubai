<template>
    <li class="nav-item dropdown">
        <a
            class="nav-link dropdown-toggle"
            href="#"
            id="pagesDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
         <i class="fas fa-bell text-dark bg-white p-1 rounded-circle" v-if="notification.length >0 "></i>
         <i class="fas fa-bell-slash"  v-if="notification.length ==0 "></i>
        </a>
        <div
            class="dropdown-menu dropdown-menu-right"
            id="app2"
            aria-labelledby="pagesDropdown"
        >
            <a
                class="dropdown-item text-dark"
                href="#"
                v-for="(item, i) in store.notification"
                :key="i"
                @click.prevent="store.removeNotification(item.id)"
            >
                Habitación: {{ item.room_name }}, estado: {{ item.status_new }}
            </a>
        </div>
    </li>
</template>
<script setup>
import { NotificationStore } from "./NotificationStore";
import { onMounted } from "vue";
import { storeToRefs } from "pinia";
import { HelperStore } from "../../HelperStore";
import { RoomStore } from "../Room/RoomStore";

const room = RoomStore()
const helper = HelperStore();
const store = NotificationStore();

const { notification,update_rooms } = storeToRefs(store);

onMounted(() => {
    store.getNotifications();

    // Pusher.logToConsole = true;

    var pusher = new Pusher("4d221fa1e35970a97f38", {
        cluster: "sa1",
    });

    var channel = pusher.subscribe("notification");

    channel.bind("notification", function (data) {
        console.log("new_event", data);
        notification.value.push(data);
        if(helper.permiss.in_view_rooms){
            console.log('evento');
            new Promise((res,rej) =>{
                room.getRooms()
            })
            update_rooms.value = true

        }
    });

    var channel = Echo.channel("notification").listen(
        "notification",
        (data) => {}
    );
});
</script>
