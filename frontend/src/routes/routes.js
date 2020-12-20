import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";

import TableList from "@/pages/TableList.vue";
import MatchesList from "@/pages/MatchesList.vue";
import PlayersList from "@/pages/PlayersList.vue";
import Login from "@/pages/Login.vue";
import About from "@/pages/About.vue";

const routes = [
  {
    path: "/",
    component: DashboardLayout,
    redirect: "/players",
    children: [
      {
        path: "login",
        name: "Login",
        component: Login
      },
      {
        path: "players",
        name: "Players",
        component: PlayersList
      },
      {
        path: "teams",
        name: "Team List",
        component: TableList
      },
      {
        path: "matches",
        name: "Matches",
        component: MatchesList
      },
      {
        path: "about",
        name: "About",
        component: About
      }
    ]
  }
];

export default routes;
