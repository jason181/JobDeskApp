import Vue from 'vue'
import VueRouter from 'vue-router'
// import i18n from 'i18n'
import Vuetify from 'vuetify';
import axios from 'axios';
import VueAxios from 'vue-axios';
import theme from './plugins/theme'
// import Vuelidate from 'vuelidate';
import { routes } from './routes'
// import { setupComponents } from './setup-components';
// import Controller from './httpController'
// import store from './store'

import 'vuetify/dist/vuetify.min.css';
// import 'font-awesome/css/font-awesome.css';  
import '@mdi/font/css/materialdesignicons.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'


import App  from './components/App'
import http from './http'
// http.init();
// setupComponents(Vue);
Vue.use(VueRouter);
Vue.use(Vuetify,
    {
        iconfont: 'mdi',
        theme
    }
);
// Vue.use(Vuetify,{
//     iconfont: 'mdi',

//   });
// Vue.use(Vuelidate);
Vue.use(VueAxios, axios);



const router = new VueRouter({
    base:'/',
    mode: 'history',
    routes,
});

Vue.router = router

new Vue({
    el: '#app',
    router,
    // vuetify : new Vuetify(),
    // store,
    // data: {
    //     themeColor: '#1E88E5',
    // },
    render: h => h(App)
})
.$mount('#app');
