<template>
  <div>
  

    <select v-model="selected">
      <option :value="null" disabled hidden>Choose</option>
      <option v-for="option in teams" :key="option.team_id">
        {{ option.team_name }}
      </option>
    </select>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "select-team",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    },
    teams: {
      type: Array
    }
  },
  data() {
    return {
      selected: null
    };
  },
  watch: {
    selected: function() {
      if (this.selected !== null) {
        this.$emit("selectedTeam", this.selected);
      }
    }
  },
  methods: {
    // ...mapActions({
    //   getPlayersByTeam: "getPlayersByTeam"
    // })
    // getPlayersByTeam(team) {
    //   fetch("http://localhost/footballapi/index.php?team=" + team)
    //     .then(resp => resp.json())
    //     .then(data => {
    //       this.players = data;
    //     });
    // }
  }
};
</script>
