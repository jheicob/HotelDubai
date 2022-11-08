import { defineStore, storeToRefs } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { HelperStore } from "@/HelperStore";

export const ConfigurationStore = defineStore("ConfigurationStore", () => {
    //this var for helper
    const useHelper = HelperStore();
    const config = ref({});
    const cancel_time = ref({
        hours: '00',
        minutes: '00',
        seconds: '00'
    })
    const warning_time = ref({
        hours: '00',
        minutes: '00',
        seconds: '00'
    })

    function formatCancelTime(time){
        let [hours,minutes,seconds] = time.split(':')
        cancel_time.value = {
            hours,minutes,seconds
        }
    }

    const getConfiguration = () => {
        var urlKeeps = "/configuracion/get";
        axios
            .get(urlKeeps)
            .then((response) => {
                let {attributes} = response.data.data 
                config.value = {
                    env: attributes.env,
                    fiscal_machine_serial: attributes.fiscal_machine_serial,
                    exchange_rate: attributes.exchange_rate,
                    warning_time: attributes.warning_time,
                    cancel_time: attributes.cancel_time
                }
                formatCancelTime(attributes.cancel_time);
                response.data.data;
                $("#dataTable").DataTable().destroy();
                this.$nextTick(function () {
                    $("#dataTable").DataTable({
                        // DataTable options here...
                    });
                });
            })
            .catch((err) => useHelper.getErrorRequest(err));
    };
    const putConfig = () => {
        useHelper.desactiveButton = true;

        var url = "/configuracion"
        axios
            .post(url, config.value)
            .then((response) => {
                location.reload()
            })
            .catch((err) => {
                useHelper.getErrorRequest(err);
            })
            .finally(() => (useHelper.desactiveButton = false));
    };
    return {
        putConfig,
        getConfiguration,
        config,
        cancel_time
    };
});
