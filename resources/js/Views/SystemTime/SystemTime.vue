<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <permissions-data-table
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import PermissionsDataTable from "./Table/SystemTimeDataTable.vue";

export default {
  name: "SystemTime",
  components: {
    PermissionsDataTable,
  },
  props: {
    create: {
      type: Number,
      default: 0,
    },
    deletet: {
      type: Number,
      default: 0,
    },
    updated: {
      type: Number,
      default: 0,
    },
  },
};
</script>