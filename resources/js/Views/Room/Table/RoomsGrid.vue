<template>
	<div class="col-1 p-1">
		<section
			class="tile widget-appointments mb-0"
			@click="showBody = !showBody"
			:style="[
				getGridColor(item.relationships.roomStatus.attributes.color.css),
				'color:white',
			]"
		>
			<div
				class="tile-header dvd dvd-btm"
				style="border-color: rgba(255, 255, 255, 0.2)"
			>
				<h1 class="custom-font" style="font-size: 16px">
					<!--            {{item.relationships.roomStatus.attributes.name }} -->
					{{ item.attributes.name }}
				</h1>

				<ul class="controls" style="background-color: rgba(0, 0, 0, 0.11)">
					<li>
						<!-- <a href="#" @click="room.showCreateReception(item)" >
                            <i class="fa-regular fa-file-lines"></i>
                        </a>-->

						<a href="#" @click="room.showCreateReception(item)">
                            <i class="fas fa-receipt text-white"></i>
						</a>
						<!-- <a  data-toggle="modal" data-target="#myModalTarifa<?php echo $habitacion->id; ?>">
                        <i class="fa fa-arrow-circle-left"></i>  </a> -->
					</li>
				</ul>
			</div>
			<!-- /tile header -->

			<div style="font-size: 13px" class="text-center dvd dvd-btm pb-2">
				<div v-if="!reception.isOcupped(item)">
					<br />
					<br />
					<br />
				</div>

				{{
					item.relationships.partialCost.relationships.roomType.attributes.name
				}}
				<br />
				{{ room.showPartialAndRate(item) }}
				<br />
				<div v-if="reception.isOcupped(item)">
					<span>
						in:<br />
						{{ item.relationships.receptionActive?.attributes.date_in ?? "" }}
						<br />
						out:<br />
						{{
							item.relationships.receptionActive?.attributes.date_out ?? ""
						}}
					</span>
					<br />
					<span :class="cont_add != '' ? 'fw-bold' : ''">
						{{ cont_add + getTimeInMinutesAndSeconds(countdown) }}
					</span>
				</div>
				<div v-if="!reception.isOcupped(item)"><br /><br /></div>
			</div>

			<!-- tile body -->
			<!--                <div class="tile-body" style="padding: 1px;">
                    <h4 style="text-align: center;"><i class="fa fa-bed"></i>
                        {{item.attributes.name}}
                        </h4>
</div> -->
			<!-- /tile body -->

			<div
				class="modal fade bs-example-modal-xm"
				id="myModalCheckOut"
				role="dialog"
				aria-labelledby="myModalLabel"
			>
				<div class="modal-dialog modal-info">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button
									type="button"
									class="close"
									data-dismiss="modal"
									aria-label="Close"
								>
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" style="color: black">
									<span class="fa fa-hotel"></span> Habitaci??n Nombre
								</h4>
							</div>

							<div class="modal-footer">
								<!--                       <center>
                            <a href="index.php?view=proceso_cambiar&id=<?php echo $proceso->id; ?>" class="btn btn-outline btn-warning pull-left"> CAMBIAR HABITACI??N?</a>

                            <a href="index.php?view=proceso_salida&id=<?php echo $proceso->id; ?>" class="btn btn-outline btn-primary pull-left">IR A PRE-CUENTA</a>
     </center>-->
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
			</div>
			<!-- {{ item.attributes.name }}
                <br />
                {{
                    `$${item.attributes.rate_current} (${item.relationships.partialCost.relationships.partialRate.attributes.name})`
                }}

                <div class="d-flex align-items-center h-100">
                    <div class="text-center w-100">
                        <ButtonComponent
                            :btnClass="['btn-info', 'mx-1']"
                            text="Detalle"
                            @click="room.showDetail(item)"
                        />
                        <ButtonComponent
                            v-if="room.ShowOcuppyButton(item)"
                            :btnClass="['btn-info', 'mx-1']"
                            text="Ocupar"
                            @click="room.ShowOccuppyModal(item)"
                        />
                        <ButtonComponent
                            v-if="room.ShowFreeButton(item)"
                            :btnClass="['btn-info', 'mx-1']"
                            text="Liberar"
                            @click="room.FreeRoom(item)"
                        />
                        <ButtonComponent
                            v-if="room.ShowExtendButton(item)"
                            :btnClass="['btn-info', 'mt-2', 'mx-1']"
                            text="Extender"
                            @click="room.showDetail(item)"
                        />
                        <ButtonComponent
                            v-if="room.ShowCleanButton(item)"
                            :btnClass="['btn-info', 'mt-2', 'mx-1']"
                            text="Limpiar"
                            @click="room.UpdateCleanRoom(item)"
                        />
                    </div>
                </div>
                <div v-if="item.relationships.roomStatus.attributes.name == 'Ocupado'">
                    <br />
                    <b>Tiempo Restante</b>
                </div>

                <b>Precio - Parcial:</b>
                <br />
                {{ item.relationships.roomStatus.attributes.name }} -->
		</section>
	</div>
</template>

<script setup>
	import { ref, computed, toRefs, onMounted, watch, onUpdated } from "vue";
	import CardComponent from "@/components/CardComponent.vue";
	import { HelperStore } from "@/HelperStore";
	import { RoomStore } from "../RoomStore";
	import ButtonComponent from "@/components/ButtonComponent.vue";
	import ModalComponent from "@/components/ModalComponent.vue";
	import { receptionStore } from "../Reception/ReceptionStore.js";
	import { storeToRefs } from "pinia";
	import dayjs from "dayjs";
	import { ConfigurationStore } from "../../Configuration/ConfigurationStore";
    import { NotificationStore } from "../../Notificaction/NotificationStore";

    const notification = NotificationStore();

    const {update_rooms,cont_rooms} = storeToRefs(notification)

    onUpdated(() => {
        if(update_rooms.value){
            console.log('recibido',helper.all.length);
            let date =
			    item.value.relationships.receptionActive?.attributes.date_out ?? dayjs();
            let ocuped = item.value.relationships.receptionActive != null;

            setupCountdownTimer(date, ocuped);
            cont_rooms.value ++;

            if(cont_rooms.value >= helper.all.length*3){
                update_rooms.value = false;
                cont_rooms.value = 0
            }
        }
    })

	const config = ConfigurationStore();
	const helper = HelperStore();
	const room = RoomStore();
	const reception = receptionStore();
	const countdown = ref(0);

	// const {countdown, date_out} = storeToRefs(reception);
	var isSameOrAfter = require("dayjs/plugin/isSameOrAfter");
	dayjs.extend(isSameOrAfter);

	onMounted(() => {
		let date =
			item.value.relationships.receptionActive?.attributes.date_out ?? dayjs();
		let ocuped = item.value.relationships.receptionActive != null;
		setupCountdownTimer(date, ocuped);
	});



	const updateItem = () => {
		if (helper.permiss.updated) {
			//			console.log(item);
			helper.ShowUpdatedModal(item.value, room.setForm);
		}
	};

	// props for the component
	const props = defineProps({
		item: {
			type: Object,
			required: true,
		},
		footerStyle: {
			type: Array,
			default: [],
		},
	});

	const { item } = toRefs(props);
	const cont_add = ref("");

	const temp_state = ref("");

	const isWarningTime = () => {
		if (item.value.relationships.receptionActive == null) return false;
		let date = dayjs(item.value.relationships.receptionActive.attributes.date_out);

		if (temp_state.value == "") {
			let warning_time = config.config.warning_time;
			if (warning_time) {
				temp_state.value = warning_time.split(":");
			}
		}

		date = date
			.subtract(parseInt(temp_state.value[0]), "h")
			.subtract(parseInt(temp_state.value[1]), "m")
			.subtract(parseInt(temp_state.value[2]), "s");
		return dayjs().isSameOrAfter(date);
	};
	const getGridColor = (color) => {
		if (cont_add.value == "-") {
			let color = config.config.color_past_time.css ?? "white";
			return color;
		}
		// else if (isWarningTime()) {
		// 	let color = config.config.color_warning_time?.css ?? 'white'
		// 	return color
		// }
		return color;
	};
	const setupCountdownTimer = (date, ocuped) => {
		if (!ocuped) return 0;
		let timer = setInterval(() => {
			countdown.value = dayjs(date).valueOf() - dayjs().valueOf();

			if (countdown.value <= 0) {
				cont_add.value = "-";
				countdown.value = -countdown.value;
				// clearInterval(timer);
			}
		}, 1000);
	};

	const getTimeInMinutesAndSeconds = (millis) => {
		var seconds = (millis / 1000).toFixed(0);
		var minutes = Math.floor(seconds / 60);
		var hours = "00";
		if (minutes > 59) {
			hours = Math.floor(minutes / 60);
			hours = hours >= 10 ? hours : "0" + hours;
			minutes = minutes - hours * 60;
			//    minutes = (minutes >= 10) ? minutes : "0" + minutes;
		}
		minutes = minutes >= 10 ? minutes : "0" + minutes;
		if (minutes == "0") minutes = "00";

		seconds = Math.floor(seconds % 60);
		seconds = seconds >= 10 ? seconds : "0" + seconds;
		return hours + ":" + minutes + ":" + seconds;
	};

	function setNumber(number) {
		if (number < 10) return `0${number}`;
		return number;
	}
	const showBody = ref(false);
	// const item.relationships.roomStatus.attributes.name == 'Ocupado'rate = pro.;
	// let part =
	// 	pro.item.relationships.partialCost.relationships.partialRate.attributes.name;
</script>

<style></style>
