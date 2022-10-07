import {defineStore} from 'pinia'
import { ref } from 'vue'
import axios from "axios";

export const RoleStore = defineStore('RoleStore', () => {
    const roles = ref([]);

    const getRoles = () => {
        var urlKeeps = "/roles/get";
        axios
            .get(urlKeeps)
            .then((response) => {
                roles.value = response.data.data.map(function (elt) {
                    return {
                        name: elt.attributes.name,
                        id: elt.id
                    };
                });
            })
            .catch((err) => {});
    }

    return {
        roles,
        getRoles
    }
})
