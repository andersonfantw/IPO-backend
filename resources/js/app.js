/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('side-menu', require('./components/SideMenu.vue').default);

Vue.component('unaudited-list1', require('./components/UnauditedList1.vue').default);

Vue.component('unaudited-list2', require('./components/UnauditedList2.vue').default);

Vue.component('rejected-list1', require('./components/RejectedList1.vue').default);

Vue.component('reaudit-list1', require('./components/ReauditList1.vue').default);

Vue.component('audit-client', require('./components/AuditClient.vue').default);

Vue.component('view-client', require('./components/ViewClient.vue').default);

Vue.component('deliverable-list2', require('./components/DeliverableList2.vue').default);

Vue.component('sending-email-list', require('./components/SendingEmailList.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from "./store";

const app = new Vue({
    store,
}).$mount('#app');
