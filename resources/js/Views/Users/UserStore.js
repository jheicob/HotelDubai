import { defineStore } from "pinia";
import { HelperStore } from "../../HelperStore";
import { ref } from "vue";
import toastr from "toastr";
import Swal from "sweetalert2";
import axios from "axios";

export const UserStore = defineStore("UserStore", () => {
    const Helper = HelperStore()
    const permiss = ref({
        create: 0,
        deletet: 0,
        updated: 0,
    });

    const keeps = ref([]);
    const pagination = ref({
        total: 0,
        current_page: 0,
        per_page: 25,
        last_page: 0,
        from: 0,
        to: 0,
    });
    const form = ref({
        name: null,
        email: null,
        password: null,
        fiscal_machine_id:1,

        role_id: [],
    })
    const errors = ref([])

    const getClearFormObject = () => {
        return {
            name: null,
            email: null,
            password: null,
            fiscal_machine_id:1,
            role_id: [],
        };
    }

    const getKeeps = (page = 1) => {
        var urlKeeps = "/users/getPaginate?page=" + page;
        axios
            .get(urlKeeps, {
                pag: pagination.value.per_page,
            })
            .then((response) => {
                keeps.value = response.data.data;
                pagination.value = response.data.meta;

                $("#dataTable").DataTable().destroy();
                this.$nextTick(function () {
                    $("#dataTable").DataTable({});
                });
            })
            .catch((err) => {});
    };

    const deletePermission = (keep) => {
        Swal.fire({
            title: "Eliminar",
            text: "estas seguro de esta accion",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "si",
            cancelButtonText: "no",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    "¡Eliminado!",
                    "Su registro ha sido eliminado.",
                    "success"
                );
                var url = "users/delete/" + keep.id;
                axios.delete(url).then((response) => {
                    getKeeps();
                });
            }
        });
    };

    const OpenCreateUser = () => {
        $("#exampleModal").modal("show");
    };

    const UpdatedUser = (user) => {
        setFormUpdate(user)
        $("#exampleModal2").modal("show");
    };

    const createUser = () => {
        Helper.desactiveButton = true;
        var url = "/users/create";
        form.value.role_id = form.value.role_id.map(function (elt) {
            return { role_id: elt.id };
        });
        axios
            .post(url, form.value)
            .then((response) => {
                errors.value = [];
                form.value = getClearFormObject();
                toastr.success("Usuaio Creado");
                $("#exampleModal").modal("hide");
                getKeeps()
            })
            .catch((error) => {
            Helper.desactiveButton = false;

                if (error.response.status == 422) {
                    errors.value = error.response.data.errors;
                }
                for (error in errors.value) {
                    toastr.error(errors.value[error]);
                }
            });
    }

    const putUser = () => {
        Helper.desactiveButton = true;

        var url = "/users/" + form.value.id;
                form.value.role_id = form.value.role_id.map(function (elt) {
					return { role_id: elt.id };
				});
				axios
					.put(url, form.value)
					.then((response) => {
						errors.value = [];
						form.value = getClearFormObject();
						toastr.success("Usuaio Modificado");
						$("#exampleModal2").modal("hide");
                        getKeeps()
					})
					.catch((error) => {
                        Helper.desactiveButton = false;
						if (error.response.status == 422) {
							errors.value = error.response.data.errors;
						}
						for (error in errors.value) {
							toastr.error(errors.value[error]);
						}
					});
    }

    const setFormUpdate = (user) => {
        form.value.name = user.attributes.name;
        form.value.email = user.attributes.email;
        form.value.id = user.id;
        form.value.fiscal_machine_id = user.relationships.fiscalMachine?.id ?? 1;
        form.value.role_id = user.relationships.roles.map(function (elt) {
            return { name: elt.attributes.name, id: elt.id };
        });
    }

    const fiscalMachines = ref([])
    const getFiscalMachines = () => {

        axios
           .get("configuration/fiscal-machines")
           .then(res => {
               fiscalMachines.value = res.data.data;
           })
    }

    return {
        permiss,
        keeps,
        form,
        fiscalMachines,
        getFiscalMachines,
        // errors,
        pagination,
        getKeeps,
        deletePermission,
        OpenCreateUser,
        UpdatedUser,
        createUser,
        setFormUpdate,
        putUser
    };
});
