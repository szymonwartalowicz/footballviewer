<template>
  <div>
    <select v-model="selected">
      <option :value="null" disabled hidden>Choose</option>
      <option v-for="option in teams" :key="option.value">
        {{ option.name }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: "select-team",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      selected: null,
      teams: [],
      players: []
    };
  },
  created() {
    this.getTeams();
  },
  watch: {
    selected: function() {
      if (this.selected !== null) {
        let players = this.getPlayersByTeam(this.selected);
      }
    },
    players: function() {
      this.$emit("selectedTeam", this.players);
    }
  },
  methods: {
    getTeams() {
      fetch("http://localhost/footballapi/index.php?teams")
        .then(resp => resp.json())
        .then(data => {
          this.teams = data;
        });
    },
    getPlayersByTeam(team) {
      fetch("http://localhost/footballapi/index.php?team=" + team)
        .then(resp => resp.json())
        .then(data => {
          this.players = data;
        });
    }
  }
};
</script>
