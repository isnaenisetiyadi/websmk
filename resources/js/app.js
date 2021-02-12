require('./bootstrap');
import 'bootstrap';
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';

window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueConfirmDialog from 'vue-confirm-dialog';
import Notifications from 'vue-notification';
import VueEditor from 'vue-quill-editor';
import Moment from 'moment';
import VueCompositionAPI from '@vue/composition-api';
import PulseLoader from 'vue-spinner/src/DotLoader';



Object.defineProperty(Vue.prototype, '$bus', {
    get() {
        return this.$root.bus;
    }
})

window.bus = new Vue();

Vue.use(VueRouter);
Vue.use(VueConfirmDialog);
Vue.use(Notifications);
Vue.use(VueEditor);
Vue.use(VueCompositionAPI);
Vue.use(PulseLoader);
Vue.component('vue-confirm-dialog', VueConfirmDialog.default);
Vue.component('notifications', Notifications.default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('vue-spinner', PulseLoader);


Vue.filter('formatDate', function(value) {
    if (value) {
        return Moment(String(value)).format('DD MMMM YYYY')
            // return Moment(String(value)).format('hh:mm')
    }
})
Vue.filter('formatTime', function(value) {
    if (value) {
        // return Moment(String(value)).format('MM/DD/YYYY hh:mm')
        return Moment(String(value)).format('HH:mm')
    }
})
Vue.filter('subStr', function(value) {
    if (value) {
        return String(value).substring(0, 50);
    }
})
Vue.filter('subStr12', function(value) {
    if (value) {
        return String(value).substring(0, 12);
    }
})
Vue.filter('subStr23', function(value) {
    if (value) {
        return String(value).substring(0, 25);
    }
})
Vue.filter('subStr33', function(value) {
    if (value) {
        return String(value).substring(0, 33);
    }
})
Vue.filter('subStr150', function(value) {
    if (value) {
        return String(value).substring(0, 125);
    }
})
Vue.filter('subStr200', function(value) {
    if (value) {
        return String(value).substring(0, 200);
    }
})
Vue.filter('subStrBtn', function(value) {
    if (value) {
        return String(value).substring(0, 4);
    }
})
Vue.filter('upperCase', function(value) {
    if (value) {
        return String(value).toUpperCase();
    }
})




import routes from './route/routes';
const router = new VueRouter({
    routes
})


// import moment from 'moment';

// Vue.filter('formatDate', function(value) {
//     if (value) {
//         return moment(String(value)).format('DD MMMM YYYY')
//     }
// });
// Vue.filter('formatHour', function(value) {
//     if (value) {
//         return moment(String(value)).format('hh:mm')
//     }
// });
// 

import App from './App.vue';
import store from './store';
// import storeTemporary from './store/temporary';
// import web from './effect/web';
import VueNotifications from 'vue-notifications';
Vue.use(App);
// const app = new Vue({
//     router,
//     store,
//     render: h => h(App)
// }).$mount('#app');

router.beforeEach((to, from, next) => {
    // NAVIGATION GUARD: 
    // Agar pengguna yg belum login, tidak bisa mengakses halaman tertentu
    if (to.matched.some(record => record.meta.login)) {

        if (!store.state.auth.user) {
            next({ path: '/entry/login' });
        } else {
            if (to.matched.some(record => record.meta.super_user)) {
                if (store.state.auth.user.role != "SUPER USER") {
                    next({ path: '/error/access' });
                } else {
                    next()
                }
            } else if (to.matched.some(record => record.meta.admin)) {
                // if (store.state.auth.user.role != "ADMIN") {
                //     next({ path: '/error/access' });
                // } else {
                //     next()
                // }
                switch (store.state.auth.user.role) {
                    case "SUPER USER":
                        next();
                        break;
                    case "ADMIN":
                        next();
                        break;
                    default:
                        next({ path: '/error/access' });
                }
            } else {
                next()

            }
        }

        // NAVIGATION GUARD: 
        // Agar setelah login, tidak bisa mengakses halaman login lagi
    } else {
        next()
    }
})

new Vue({
    router,
    store,
    data: {
        bus: bus
    },
    render: h => h(App)
}).$mount('#app');