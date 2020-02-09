
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)

import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';

Vue.use(VueInternationalization);

import AllIosIcon from 'vue-ionicons/dist/ionicons-ios.js'

Vue.use(AllIosIcon)

const lang = document.documentElement.lang.substr(0, 2); 
// or however you determine your current app locale

const i18n = new VueInternationalization({
    locale: lang,
    messages: Locale
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(require('vue-moment'));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('chat-component', require('./components/Chat/ChatComponent.vue'));
Vue.component('chat-user-component', require('./components/Chat/UserComponent.vue'));
Vue.component('chat-build', require('./components/Chat/ChatBuild.vue'));
Vue.component('chat-send-component', require('./components/Chat/ChatSendComponent.vue'));



Vue.component('permission-group-add', require('./components/Permissions/GroupAdd.vue'));
Vue.component('admin-users-list', require('./components/Users/AdminUsersList.vue'));
Vue.component('admin-user-edit', require('./components/Users/AdminUserEdit.vue'));
Vue.component('admin-user-create', require('./components/Users/AdminUserCreate.vue'));

Vue.component('route-receipt-image-settings', require('./components/Advertising/RouteReceiptImageSettings.vue'));
Vue.component('route-receipt-image-upload', require('./components/Advertising/UploadImage.vue'));

Vue.component('crane-search', require('./components/Crane/CraneSearch.vue'));
Vue.component('crane-search-result', require('./components/Crane/SearchResult.vue'));
Vue.component('crane-segment', require('./components/Crane/CraneSegment.vue'));


Vue.component('axios-select-city', require('./components/Axios/SelectCity.vue'));
Vue.component('axios-select-company', require('./components/Axios/SelectCompany.vue'));
Vue.component('axios-select-manager', require('./components/Axios/SelectManager.vue'));

Vue.component('company-edit', require('./components/Company/EditCompany.vue'));


Vue.component('schedule-add', require('./components/Schedules/ScheduleAdd.vue'));
Vue.component('history-table', require('./components/History/Table.vue'));
Vue.component('booking-create', require('./components/Booking/Create.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#page-container',
    i18n
});
