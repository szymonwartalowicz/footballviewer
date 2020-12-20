<template>
  <div>
    <h1>Players</h1>
    <select v-model="selected">
        <option v-for="item in teams['data']" :key="item.id">
            {{ item.name }}</option>
</select>
<span>Selected: {{ selected }}</span>
  <div v-if="players.length > 0">
      {{ players }}
  </div>
</div>
</template>
<script>

export default {
  name: 'Players',
  data () {
      return {
          teams: [],
          players: [],
          selected: 0
      }


  },
  created () {
    this.selected = this.teams.find(i => i.id === this.selected);

  },
  mounted() {
      this.getTeams();
  },
  beforeUpdate () {
      this.getPlayers(this.selected);
  },
  beforeRouteUpdate(to, from, next) {
      this.getTeams();
      next();
  },
  methods: {
    getTeams() {
            fetch('http://localhost/footballapi/index.php?get_teams_and_results')
                .then((resp) => resp.json())
                .then((data) => {
                    this.teams = data;
                } )
    },
    getPlayers(team){
            fetch('http://localhost/footballapi/index.php?players_by_team=' + team)
                .then((resp) => resp.json())
                .then((data) => {
                    this.players = data;
                })
    }
},
}
</script>
<style>
</style>
