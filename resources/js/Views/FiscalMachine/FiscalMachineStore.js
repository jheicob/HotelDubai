import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { HelperStore } from "@/HelperStore";

export const RoomTypeStore = defineStore("FiscalMachineStore", () => {
    //this var for helper
    const useHelper = HelperStore();

    const all = ref([]);

    const getFiscalMachine = () => {
        var urlKeeps = "/configuracion/FiscalMachines/get";
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

    const deleteFiscalMachines = (keep) => {
        var url = "/configuracion/FiscalMachines/delete/" + keep.id;
        axios.delete(url).then((response) => {
            getRoomTypes();
        });
    };

    const ShowCreateModal = () => {
        getEstateTypes()
        $("#exampleModal").modal("show");
    };

    const storeFiscalMachines = () => {
        useHelper.desactiveButton = true;
        var url = "/configuracion/FiscalMachines/create";
        axios
            .post(url, useHelper.form)
            .then((response) => {
                $("#exampleModal").modal("hide");
                clearForm();
                getFiscalMachine();
            })
            .catch((err) => {
                useHelper.getErrorRequest(err);
            })
            .finally(() => (useHelper.desactiveButton = false));
    };

    const clearForm = () => {
        useHelper.form = {
            name: null,
            serial: null,
            estate_type_id: '',
        };

        if (useHelper.id) {
            useHelper.id = null;
        }
    };

    const ShowUpdateModel = (permission) => {
        setForm(permission);
        getEstateTypes();
        $("#exampleModal2").modal("show");
    };

    const setForm = (reg) => {
        useHelper.form.name = reg.attributes.name;
        useHelper.form.serial = reg.attributes.serial;
        useHelper.form.estate_type_id = reg.relationships.estateType.id;
        useHelper.form.id = reg.id;
    };

    const estate_types = ref([])
    const getEstateTypes = () => {
        axios
           .get("/configuracion/estate-type/get")
           .then((response) => {
                estate_types.value = response.data.data
           })
           .catch(err => useHelper.getErrorRequest(err))
    }

    const putFiscalMachines = () => {
        useHelper.desactiveButton = true;

        var url = "/configuracion/FiscalMachines/" + useHelper.form.id;
        axios
            .put(url, useHelper.form)
            .then((response) => {
                clearForm();
                $("#exampleModal2").modal("hide");
                getFiscalMachine();
            })
            .catch((err) => {
                useHelper.getErrorRequest(err);
            })
            .finally(() => (useHelper.desactiveButton = false));
    };
    return {
        all,
        getFiscalMachine,
        deleteFiscalMachines,
        ShowCreateModal,
        ShowUpdateModel,
        storeFiscalMachines,
        clearForm,
        putFiscalMachines,
        getEstateTypes,
        estate_types
    };
});
