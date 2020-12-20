<template>
  <div>
    <md-table v-model="players">
      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="Name">{{ item.name }}</md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
export default {
  name: "DisplaPlayers",
  props: {
    players: {
      type: Array
    }
  },
  data() {
    return {};
  }
};
</script>
