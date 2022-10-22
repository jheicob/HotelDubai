import { defineStore } from 'pinia'
import { ref } from 'vue'
import toastr from "toastr";
import "toastr/build/toastr.css"
import axios from 'axios';

export const HelperStore = defineStore('HelperStore',() => {
    const desactiveButton = ref(false)
    const permiss = ref({
        create:false,
        deletet:false,
        updated: false,
    })
    const form = ref({})
    const errors = ref([])
    const url = ref('')
    const all = ref([])
    const item = ref({})

    const getErrorRequest = (err) => {
        if (err.response?.status == 422) {
            errors.value = err.response.data.data.errors;
        }else{
            errors.value = err
        }
        for (let error in errors.value) {
            toastr.error(errors.value[error]);
        }
    }

    const getAll = () => {
        var urlKeeps = `/${url.value}/get`
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
            .catch((err) => getErrorRequest(err))
    }


    const customRequest = (url,method,data,params) => {
        axios({
            method: method,
            url: url,
            data: data,
            params: params,
        })
        .then((response) => (response.data))
        .catch((err) => getErrorRequest(err))
    }

    const storeItem = (callback,idModal = "#exampleModal") => {
        desactiveButton.value = true;
        let url_store = `/${url.value}/create`
//        console.log(url_store)
        axios
            .post(url_store, form.value)
            .then((response) => {
                $(idModal).modal("hide");
                clearForm(callback)
                getAll()
            })
            .catch((err) => {
                getErrorRequest(err);
            })
            .finally(() => (desactiveButton.value = false));
    };

    const putItem = (callback, idModal = "#exampleModal2") => {
        desactiveButton.value = true;
        let url_put = `/${url.value}/${form.value.id}`;
        axios
          .put(url_put, form.value)
          .then((response) => {
            form.value = callback();
            $(idModal).modal("hide");
            getAll()
          })
          .catch((error) => (getErrorRequest(error)))
          .finally(() => (desactiveButton.value = false))
      }

    const clearForm = (callback) => {
        form.value = callback()
    }

    const deleteItem = (item) => {
        var url = `/${url.value}/delete/${item.id}`
        axios.delete(url).then((response) => {
            getAll()
        });
    }

    const ShowCreateModal = (idModal = "#exampleModal") => {
        $(idModal).modal("show");
    }

    const ShowUpdatedModal = (permission, callback, idModal = "#exampleModal2") => {
        setForm(callback,permission)
        $(idModal).modal("show");
    }

    const setForm = (callback, item) => {
        form.value = callback(item)
    }

    return {
        customRequest,
      form,
        url,
        all,
        ShowCreateModal,
        ShowUpdatedModal,
        desactiveButton,
        permiss,
        getErrorRequest,
        getAll,
        deleteItem,
        storeItem,
        setForm,
        clearForm,
        errors,
        putItem,
        item
    }
})
