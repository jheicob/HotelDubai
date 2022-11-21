<template>
<div>
    <div class="form-group">
        <div class="form-label-group">
            <input type="email" id="inputEmail"
                class="form-control" placeholder="Email address"
                required="required" autofocus="autofocus" name="email"
                 autocomplete="email">

            <label for="inputEmail">Correo electrónico</label>
        </div>
    </div>
    <div class="form-group">
        <div class="form-label-group">
            <input type="password" id="inputPassword"
                class="form-control" placeholder="Password"
                name="password" required autocomplete="current-password">
            <label for="inputPassword">Contraseña</label>
        </div>
    </div>
    <!-- <div class="form-group">
            <select
                id="typeEstate"
                class="form-control"
                required
                v-model="login_option"
                >
                <option v-for="(type,i) in typeEstates" :key="i" :value="type.id">
                    {{type.name}}
                </option>
            </select>
            <label for="typeEstate">Tipo de Inmueble</label>
    </div> -->
    <div class="form-group">
        <div class="checkbox">
            <label style="color:dark">
                <input
                    type="checkbox"
                    value="remember-me"
                    name="remember"
                    id="remember"
                    :checked="remember"
                    >
                Recordar Contraseña
            </label>
        </div>
    </div>
</div>

</template>

<script setup>
    import {RoomStore} from "../Room/RoomStore"
    import {storeToRefs} from 'pinia'
    import {onMounted, ref} from "vue"
    import axios from "axios"
    import {HelperStore} from '../../HelperStore'

    const room = RoomStore()
    const helper = HelperStore()

    const {login_option} = storeToRefs(room)

    const typeEstates = ref([])
    const getTypeEstate = () => {

        axios
            .get('configuration/EstateType')
            .then(res => {
                typeEstates.value = res.data.data.map(item => ({
                    name: item.attributes.name,
                    id: item.id,
                }))
                typeEstates.value.unshift({
                    id: '',
                    name: 'Todo',
                })
            })
            .catch(error => helper.getErrorRequest(error))
    }

    onMounted(() => {
        login_option.value= ''
        getTypeEstate()
    })
    const props = defineProps({
        remember:{
            type:Boolean,
            default:false,
        }
    })
</script>
