import Vue from 'vue';
import VueRouter from 'vue-router';
import Dashboard from './pages/Dashboard.vue';
import Transfer from './pages/Transfer.vue';
import Withdraw from './pages/Withdraw.vue';
import Deposit from './pages/Deposit.vue';

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard,
        meta: { navOrder: 0 },
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { navOrder: 1 },
    },
    {
        path: '/transfer',
        name: 'transfer',
        component: Transfer,
        meta: { navOrder: 2 },
    },
    {
        path: '/Deposit',
        name: 'deposit',
        component: Deposit,
        meta: { navOrder: 3 },
    },
    {
        path: '/Withdraw',
        name: 'withdraw',
        component: Withdraw,
        meta: { navOrder: 4 },
    },
    // {
    //     path: '/transfer',
    //     name: 'transfer',
    //     component: () => import(/* webpackChunkName: "about" */ './pages/About.vue')
    // },
];

const router = new VueRouter({
  routes,
});

export default router;
