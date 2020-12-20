import Vue from 'vue'
import Router from 'vue-router'
import Matches from '@/components/Matches'
import Tables from '@/components/Tables'
import Players from '@/components/Players'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/matches',
      name: 'Matches',
      component: Matches
    },
    {
      path: '/tables',
      name: 'Tables',
      component: Tables
    },
    {
      path: '/players',
      name: 'Players',
      component: Players
    }
  ]
})
