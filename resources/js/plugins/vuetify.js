// import Vue from 'vue';
// import vuetify from 'vuetify';
// import 'vuetify/dist/vuetify.min.css'
// import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';
import Vuetify from 'vuetify';

Vue.use(Vuetify)

const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdi'
    },
    theme: {
        themes: {
            light: {
                primary: '#3f51b5',
                secondary: '#b0bec5',
                accent: '#8c9eff',
                error: '#b71c1c',
                info: '#00Acc1',
                warning: '#FFA726'
            }
        }
    }
})
export default vuetify