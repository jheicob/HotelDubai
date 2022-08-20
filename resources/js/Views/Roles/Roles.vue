<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <roles-data-table
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import RolesDataTable from "./Table/RolesDataTable.vue";

export default {
  name: "Roles",
  components: {
    RolesDataTable,
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