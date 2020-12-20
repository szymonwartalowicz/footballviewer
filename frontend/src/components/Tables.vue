<template>
  <div>
    <h1>Tables</h1>
    <table>
        <tr>
            <th>Team</th>
            <th>W</th>
            <th>L</th>
            <th>D</th>
        </tr>
        <tr class="result" :key="item.id" v-for="item of teams['data']">
            <td v-html="item.name"></td>
            <td v-html="item.wins"></td>
            <td v-html="item.losses"></td>
            <td v-html="item.draws"></td>
        </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: 'Tables',
  data() {
      return {
          teams: [],
          error: null,
      }
  },
  mounted() {
      this.getTeams();
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


    }
},
}
</script>
<style>
</style>
