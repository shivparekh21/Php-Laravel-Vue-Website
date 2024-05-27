import Vue from 'vue';
import VueRouter from 'vue-router';
import PolarisVue from '@hulkapps/polaris-vue';
import '@hulkapps/polaris-vue/dist/polaris-vue.css';

import axios from  'axios';
import Master from '../components/layouts/Master'
import CustomerHome from '../components/customers/home'
import Products from '../components/products/products'

Vue.use(VueRouter);
Vue.use(PolarisVue);

const router = new VueRouter({
    mode:'history',
    routes:[
        {
            path:'/',
            component:Master,
            children: [
                {
                    path:'/customerHome',
                    component:CustomerHome,
                },
                {
                    path:'/products',
                    component: Products
                }
            ],
        },
    ]
})

export default router
