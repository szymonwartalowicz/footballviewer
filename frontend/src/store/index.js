import Vue from "vue";
import Vuex from "vuex";
import { $fetch } from "../plugins/fetch";

Vue.use(Vuex);

const store = new Vuex.Store({
  state() {
    return {
      adminOn: null,
      playerDetails: null,
      editedDetails: null,
      teams: null,
      matches: null,
      results: null,
      teamPlayers: null
    };
  },
  getters: {
    adminOn: state => state.adminOn,
    playerDetails: state => state.playerDetails,
    teams: state => state.teams,
    matches: state => state.matches,
    results: state => state.results,
    teamPlayers: state => state.teamPlayers
  },
  mutations: {
    updateTeamPlayers: (state, players) => {
      state.teamPlayers = players;
    },
    updateResults: (state, results) => {
      state.results = results;
    },
    updateMatches: (state, matches) => {
      state.matches = matches;
    },
    updateTeams: (state, teams) => {
      state.teams = teams;
    },
    adminOn: (state, user) => {
      state.adminOn = user;
    },
    updatePlayerDetails: (state, details) => {
      state.playerDetails = details;
    },
    playerDetailsEdit(state, status) {
      state.playerDetails.edit = status;
    }
  },
  actions: {
    async getPlayersByTeam({ commit }, team) {
      try {
        const teamPlayers = await $fetch("?team=" + team);
        commit("updateTeamPlayers", teamPlayers);
      } catch (error) {
        console.log(error);
      }
    },
    async getTeamsAndResults({ commit }) {
      try {
        const results = await $fetch("?results");
        commit("updateResults", results);
      } catch (error) {
        console.warn(error);
      }
    },
    async getMatches({ commit }) {
      try {
        const matches = await $fetch("?matches");
        commit("updateMatches", matches);
      } catch (error) {
        console.warn(error);
      }
    },
    async getTeams({ commit }) {
      try {
        const teams = await $fetch("?teams");
        commit("updateTeams", teams);
      } catch (error) {
        console.warn(error);
      }
    },
    async getPlayerDetails({ commit }, player) {
      try {
        const playerDetails = await $fetch("?player=" + player["name"]);
        playerDetails["edit"] = false;
        commit("updatePlayerDetails", playerDetails);
      } catch (error) {
        console.warn(error);
      }
    },
    editOn({ commit }) {
      commit("playerDetailsEdit", true);
    },
    editOff({ commit }) {
      commit("playerDetailsEdit", false);
    }
  }
});

export default store;
