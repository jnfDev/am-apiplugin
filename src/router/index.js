import { createRouter, createWebHashHistory } from 'vue-router'
import Table from '../views/Table.vue'
import Graph from '../views/Graph.vue'
import Settings from '../views/Settings.vue'


const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: '/',
      name: 'table',
      component: Table
    },
    {
        path: '/graph',
        name: 'graph',   
        component: Graph 
    },
    {
        path: '/settings',
        name: 'settings',   
        component: Settings 
    }
  ]
})

export default router
