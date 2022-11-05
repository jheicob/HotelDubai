import { defineStore, storeToRefs } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { HelperStore } from "@/HelperStore";

export const ConfigurationStore = defineStore("ConfigurationStore", () => {
    //this var for helper
    const useHelper = HelperStore();
    const config = ref({});
    const all = ref([]);

    const getConfiguration = () => {
        var urlKeeps = "/configuracion/get";
        axios
            .get(urlKeeps)
            .then((response) => {
                config.value = response.data.data;
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
        var url = "/invoice/Product/delete/" + keep.id;
        axios.delete(url).then((response) => {
            getRoomTypes();
        });
    };

    const ShowCreateModal = () => {
        $("#exampleModal").modal("show");
    };
    const {form} = storeToRefs(useHelper)
    const storeRoomType = () => {
        useHelper.desactiveButton = true;
        const {stock, stock_min} = inventory.value
        form.value.inventory ={
            stock,
            stock_min
        }
        var url = "/invoice/Product/create";
        axios
            .post(url, form.value)
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

    const inventory = ref({
        stock: 0,
        stock_min: 0
    })
    const clearForm = () => {
        useHelper.form = {
            name: '',
            description: '',
            purchase_price: 0,
            sale_price: 0,
            visible: true,
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
        useHelper.form.description = reg.attributes.description;
        useHelper.form.id = reg.id;
        useHelper.form.purchase_price= reg.attributes.purchase_price,
        useHelper.form.sale_price= reg.attributes.sale_price,
            useHelper.form.visible= reg.attributes.visible == 1,
        inventory.value.stock = reg.relationships.inventory.attributes.stock
        inventory.value.stock_min = reg.relationships.inventory.attributes.stock_min
    };

    const putRoomType = () => {
        useHelper.desactiveButton = true;

        var url = "/invoice/Product/" + useHelper.form.id;
        const {stock, stock_min} = inventory.value
        form.value.inventory ={
            stock,
            stock_min
        }

        axios
            .put(url, form.value)
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
        getConfiguration,
        deleteRoomType,
        ShowCreateModal,
        ShowUpdateModel,
        storeRoomType,
        clearForm,
        putRoomType,
        inventory
    };
});
