import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { HelperStore } from "@/HelperStore";

export const ExtraGuestStore = defineStore("ExtraGuestStore", () => {
    //this var for helper
    const useHelper = HelperStore();

    const all = ref([]);

    const getRoomTypes = () => {
        var urlKeeps = "/configuracion/extra-guest/get";
        axios
            .get(urlKeeps)
            .then((response) => {
                all.value = response.data.data;
                $("#dataTable").DataTable().destroy();
                this.$nextTick(function () {
                    $("#dataTable").DataTable({
                        // DataTable options here...
                    });
                });
            })
            .catch((err) => useHelper.getErrorRequest(err));
    };

    const deleteRoomType = (keep) => {
        var url = "/configuracion/extra-guest/delete/" + keep.id;
        axios.delete(url).then((response) => {
            getRoomTypes();
        });
    };

    const ShowCreateModal = () => {
        $("#exampleModal").modal("show");
    };

    const storeRoomType = () => {
        useHelper.desactiveButton = true;
        var url = "/configuracion/extra-guest/create";
        axios
            .post(url, useHelper.form)
            .then((response) => {
                $("#exampleModal").modal("hide");
                clearForm();
                getRoomTypes();
            })
            .catch((err) => {
                useHelper.getErrorRequest(err);
            })
            .finally(() => (useHelper.desactiveButton = false));
    };

    const clearForm = () => {
        useHelper.form = {
            name: null,
            rate: null,
        };

        if (useHelper.id) {
            useHelper.id = null;
        }
    };

    const ShowUpdateModel = (permission) => {
        setForm(permission);
        $("#exampleModal2").modal("show");
    };

    const setForm = (reg) => {
        useHelper.form.name = reg.attributes.name;
        useHelper.form.rate = reg.attributes.rate;
        useHelper.form.id = reg.id;
    };

    const putRoomType = () => {
        useHelper.desactiveButton = true;

        var url = "/configuracion/extra-guest/" + useHelper.form.id;
        axios
            .put(url, useHelper.form)
            .then((response) => {
                clearForm();
                $("#exampleModal2").modal("hide");
                getRoomTypes();
            })
            .catch((err) => {
                useHelper.getErrorRequest(err);
            })
            .finally(() => (useHelper.desactiveButton = false));
    };
    return {
        all,
        getRoomTypes,
        deleteRoomType,
        ShowCreateModal,
        ShowUpdateModel,
        storeRoomType,
        clearForm,
        putRoomType,
    };
});
