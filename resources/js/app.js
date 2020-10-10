require('./bootstrap');
window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);
import store from './store/index'


Vue.component('conversation-dashboard', require('./components/ConversationDashboard.vue').default);



const app = new Vue({
    el: '#app',
    store
});
