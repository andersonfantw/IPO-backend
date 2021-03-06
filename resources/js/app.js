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

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Permission from "./components/Permission.vue";
import ClientProgress from "./components/ClientProgress.vue";
import UnauditedList1 from "./components/UnauditedList1.vue";
import ReauditList1 from "./components/ReauditList1.vue";
import RejectedList1 from "./components/RejectedList1.vue";
import UnauditedList2 from "./components/UnauditedList2.vue";
import DeliverableList2 from "./components/DeliverableList2.vue";
import SendingEmailList from "./components/SendingEmailList.vue";
import ClientBankCards from "./components/ClientBankCards.vue";
import ClientCreditCards from "./components/ClientCreditCards.vue";
import ClientFundInRequests from "./components/ClientFundInRequests.vue";
import ClientHKFundOutRequests from "./components/ClientHKFundOutRequests.vue";
import ClientFundInternalTransferRequests from "./components/ClientFundInternalTransferRequests.vue";
import ClientOverseasFundOutRequests from "./components/ClientOverseasFundOutRequests.vue";
import ClientCreditCardFundOutRequests from "./components/ClientCreditCardFundOutRequests.vue";
import AccountReportSendingSummary from "./components/AccountReportSendingSummary.vue";
import NotificationSummary from "./components/NotificationSummary.vue";
import AeCommissionSummary from "./components/AeCommissionSummary.vue";
import CheckingDeposit from "./components/CheckingDeposit.vue";
import ClientDataUpdate from "./components/ClientDataUpdate.vue";
import SubscriptionGroup from "./components/SubscriptionGroup.vue";

const routes = [
    { path: '/Permission', component: Permission },
    { path: '/ClientProgress', component: ClientProgress },
    { path: '/UnauditedList1', component: UnauditedList1 },
    { path: '/ReauditList1', component: ReauditList1 },
    { path: '/RejectedList1', component: RejectedList1 },
    { path: '/UnauditedList2', component: UnauditedList2 },
    { path: '/DeliverableList2', component: DeliverableList2 },
    { path: '/SendingEmailList', component: SendingEmailList },
    { path: '/ClientBankCards', component: ClientBankCards },
    { path: '/ClientCreditCards', component: ClientCreditCards },
    { path: '/ClientFundInRequests', component: ClientFundInRequests },
    { path: '/ClientHKFundOutRequests', component: ClientHKFundOutRequests },
    { path: '/ClientFundInternalTransferRequests', component: ClientFundInternalTransferRequests },
    { path: '/ClientOverseasFundOutRequests', component: ClientOverseasFundOutRequests },
    { path: '/ClientCreditCardFundOutRequests', component: ClientCreditCardFundOutRequests },
    { path: '/AccountReportSendingSummary', component: AccountReportSendingSummary },
    { path: '/NotificationSummary', component: NotificationSummary },
    { path: '/AeCommissionSummary', component: AeCommissionSummary },
    { path: '/CheckingDeposit', component: CheckingDeposit },
    { path: '/ClientDataUpdate', component: ClientDataUpdate },
    { path: '/SubscriptionJob', component: SubscriptionGroup },
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import { LayoutPlugin, TabsPlugin, CardPlugin, AlertPlugin, CollapsePlugin, ModalPlugin, FormDatepickerPlugin, FormTimepickerPlugin, ListGroupPlugin, FormGroupPlugin, FormRadioPlugin, FormSelectPlugin, FormInputPlugin, ButtonPlugin, FormCheckboxPlugin, PopoverPlugin, AvatarPlugin, FormFilePlugin, OverlayPlugin, LinkPlugin, FormPlugin, PaginationNavPlugin, ProgressPlugin } from 'bootstrap-vue';
Vue.use(LayoutPlugin)
Vue.use(TabsPlugin)
Vue.use(CardPlugin)
Vue.use(AlertPlugin)
Vue.use(CollapsePlugin)
Vue.use(ModalPlugin)
Vue.use(FormDatepickerPlugin)
Vue.use(FormTimepickerPlugin)
Vue.use(ListGroupPlugin)
Vue.use(FormGroupPlugin)
Vue.use(FormRadioPlugin)
Vue.use(FormSelectPlugin)
Vue.use(FormInputPlugin)
Vue.use(ButtonPlugin)
Vue.use(FormCheckboxPlugin)
Vue.use(PopoverPlugin)
Vue.use(AvatarPlugin)
Vue.use(FormFilePlugin)
Vue.use(OverlayPlugin)
Vue.use(LinkPlugin)
Vue.use(FormPlugin)
Vue.use(PaginationNavPlugin)
Vue.use(ProgressPlugin)

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

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

Vue.component('client-credit-card-fund-out-requests', require('./components/ClientCreditCardFundOutRequests.vue').default);

Vue.component('view-client-credit-card-fund-out-requests', require('./components/ViewClientCreditCardFundOutRequest.vue').default);

Vue.component('audit-client-credit-card-fund-out-requests', require('./components/AuditClientCreditCardFundOutRequest.vue').default);

Vue.component('client-overseas-fund-out-requests', require('./components/ClientOverseasFundOutRequests.vue').default);

Vue.component('view-client-overseas-fund-out-request', require('./components/ViewClientOverseasFundOutRequest.vue').default);

Vue.component('audit-client-overseas-fund-out-request', require('./components/AuditClientOverseasFundOutRequest.vue').default);

Vue.component('client-fund-internal-transfer-requests', require('./components/ClientFundInternalTransferRequests.vue').default);

Vue.component('view-client-fund-internal-transfer-request', require('./components/ViewClientFundInternalTransferRequest.vue').default);

Vue.component('audit-client-fund-internal-transfer-request', require('./components/AuditClientFundInternalTransferRequest.vue').default);

Vue.component('client-bank-cards', require('./components/ClientBankCards.vue').default);

Vue.component('account-report-sending-summary', require('./components/AccountReportSendingSummary.vue').default);

Vue.component('account-report', require('./components/AccountReport.vue').default);

Vue.component('client-address-proof-updates', require('./components/ClientAddressProofUpdates.vue').default);

Vue.component('audit-client-address-proof-update', require('./components/AuditClientAddressProofUpdate.vue').default);

Vue.component('client-progress', require('./components/ClientProgress.vue').default);

Vue.component('view-client-bank-card', require('./components/ViewClientBankCard.vue').default);

Vue.component('audit-client-bank-card', require('./components/AuditClientBankCard.vue').default);

Vue.component('client-credit-cards', require('./components/ClientCreditCards.vue').default);

Vue.component('audit-client-credit-card', require('./components/AuditClientCreditCard.vue').default);

Vue.component('permission', require('./components/Permission.vue').default);

Vue.component('panel', require('./components/Panel.vue').default);

Vue.component('v-money', require('./components/v_money.vue').default);
// Anderson start
import VueBus from 'vue-bus';
Vue.use(VueBus);

import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect);

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
Vue.component('date-picker', DatePicker);

Vue.component('notification-summary', require('./components/NotificationSummary.vue').default);

Vue.component('notification-record', require('./components/NotificationRecord.vue').default);

Vue.component('notify-client-list', require('./components/v_notify_client.vue').default);
Vue.component('notify-group-list', require('./components/v_notify_group.vue').default);
Vue.component('notify-group-client-list', require('./components/v_notify_group_clients.vue').default);
Vue.component('system-notification-list', require('./components/v_system_notification.vue').default);

Vue.component('find-a-client', require('./components/v_find_a_client.vue').default);
Vue.component('client-chooser', require('./components/v_client_chooser.vue').default);
Vue.component('client-viewer', require('./components/v_client_viewer.vue').default);

Vue.component('send-sms-task', require('./components/v_send_sms_task.vue').default);
Vue.component('send-email-task', require('./components/v_send_email_task.vue').default);
Vue.component('send-account-overview-task', require('./components/v_send_account_overview_task.vue').default);
Vue.component('send-alloted-notice-task', require('./components/v_send_alloted_notice_task.vue').default);
Vue.component('notification-import-excel-format-example', require('./components/v_notification_import_excel_format_example.vue').default);

Vue.component('ae-commission-summary', require('./components/AeCommissionSummary.vue').default);
Vue.component('ae-commission-summary-list', require('./components/v_ae_commission_summary_list.vue').default);
Vue.component('ipo-interest-list', require('./components/v_ipo_interest_list.vue').default);
Vue.component('ipo-interest-import', require('./components/v_ipo_interest_import.vue').default);
Vue.component('ipo-interest-setting', require('./components/v_ipo_interest_setting.vue').default);
Vue.component('ae-commission-confirm', require('./components/v_ae_commission_confirm.vue').default);
Vue.component('ae-commission-detail', require('./components/v_ae_commission_detail.vue').default);

Vue.component('subscription-group', require('./components/SubscriptionGroup.vue').default);
Vue.component('add-subscription-task', require('./components/v_add_subscription_task.vue').default);
Vue.component('subscription-calculation',require('./components/v_subscription_calculation.vue').default);
// Anderson end

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from "./store";

const app = new Vue({
    store,
    router,
}).$mount('#app');
