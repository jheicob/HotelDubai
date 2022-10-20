<template>
	<div class="col-lg-2 col-xs-6">
        <section class="tile widget-appointments" :class='room.selectColor(item)'>
            <div class="tile-header dvd dvd-btm">
                <h1 class="custom-font" style="font-size: 12px;">
                    {{item.relationships.roomStatus.attributes.name }}
                </h1>
                
                <ul class="controls">
                    <li >
                        <a href="#" @click="room.showCreateReception(item)" >
                            <i class="fa fa-arrow-circle-left"></i>
                        </a>
                        <!-- <a  data-toggle="modal" data-target="#myModalTarifa<?php echo $habitacion->id; ?>">
                        <i class="fa fa-arrow-circle-left"></i>  </a> -->
                    </li>
                </ul>
            </div>
             <!-- /tile header -->

             <div style="font-size: 12px" class="text-center dvd dvd-btm pb-2">
                    <br>
                  {{item.relationships.partialCost.relationships.roomType.attributes.name }}
                    <br>
                    {{room.showPartialAndRate(item)}}
                </div>
                
            <!-- tile body -->
            <div class="tile-body" style="padding: 1px;">
                <h4 style="text-align: center;"><i class="fa fa-bed"></i> 
                    {{item.attributes.name}}
                </h4>
            </div>
            <!-- /tile body -->

            <div class="modal fade bs-example-modal-xm" id="myModalCheckOut<?php echo $habitacion->id; ?>" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-info">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: black;"><span class="fa fa-hotel"></span> Habitación Nombre</h4>
                        </div>

                        <div class="modal-footer">
                        <center>
                        <a href="index.php?view=proceso_cambiar&id=<?php echo $proceso->id; ?>" class="btn btn-outline btn-warning pull-left"> CAMBIAR HABITACIÓN?</a>

                        <a href="index.php?view=proceso_salida&id=<?php echo $proceso->id; ?>" class="btn btn-outline btn-primary pull-left">IR A PRE-CUENTA</a>
                        </center>

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
	import { ref, computed, toRefs } from "vue";
	import CardComponent from "@/components/CardComponent.vue";
	import { HelperStore } from "@/HelperStore";
	import { RoomStore } from "../RoomStore";
	import ButtonComponent from "@/components/ButtonComponent.vue";
	import ModalComponent from "@/components/ModalComponent.vue";
	const helper = HelperStore();
	const room = RoomStore();

	const updateItem = () => {
		if (helper.permiss.updated) {
			console.log(item);
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


	// const item.relationships.roomStatus.attributes.name == 'Ocupado'rate = pro.;
	// let part =
	// 	pro.item.relationships.partialCost.relationships.partialRate.attributes.name;
</script>

<style>
</style>
