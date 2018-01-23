import VeeValidate from 'vee-validate';
import Tabs from 'vue-tabs-component';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.use(VeeValidate, {
    events: 'blur',
});

Vue.use(Tabs);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app', require('./App.vue'));
Vue.component('send-message', require('./components/SendMessage.vue'));
Vue.component('message-sent', require('./components/MessageSent.vue'));
Vue.component('about-page', require('./components/AboutPage.vue'));

const EventBus = new Vue();
Object.defineProperties(Vue.prototype, {
    $eventBus: {
        get: function () {
            return EventBus;
        }
    }
});

const app = new Vue({
    el: '#app',
});
