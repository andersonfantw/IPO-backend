/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

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

Vue.component('client-fund-in-requests', require('./components/ClientFundInRequests.vue').default);

Vue.component('view-client-fund-in-request', require('./components/ViewClientFundInRequest.vue').default);

Vue.component('audit-client-fund-in-request', require('./components/AuditClientFundInRequest.vue').default);

Vue.component('client-hk-fund-out-requests', require('./components/ClientHKFundOutRequests.vue').default);

Vue.component('view-client-hk-fund-out-request', require('./components/ViewClientHKFundOutRequest.vue').default);

Vue.component('audit-client-hk-fund-out-request', require('./components/AuditClientHKFundOutRequest.vue').default);

Vue.component('client-overseas-fund-out-requests', require('./components/ClientOverseasFundOutRequests.vue').default);

Vue.component('view-client-overseas-fund-out-request', require('./components/ViewClientOverseasFundOutRequest.vue').default);

Vue.component('audit-client-overseas-fund-out-request', require('./components/AuditClientOverseasFundOutRequest.vue').default);

Vue.component('client-fund-internal-transfer-requests', require('./components/ClientFundInternalTransferRequests.vue').default);

Vue.component('view-client-fund-internal-transfer-request', require('./components/ViewClientFundInternalTransferRequest.vue').default);

Vue.component('audit-client-fund-internal-transfer-request', require('./components/AuditClientFundInternalTransferRequest.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from "./store";

const app = new Vue({
    store,
}).$mount('#app');
