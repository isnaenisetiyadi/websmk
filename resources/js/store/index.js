import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist';

// import modul dari folder stores
import auth from './stores/auth';
import news from './stores/news';
import constant from './stores/constant';
import pendidikan from './stores/pendidikan';
import pendidikanDialog from './stores/pendidikandialog';
import addMode from './stores/addMode';
import spinner from './stores/spinner';
import jurusan from './stores/jurusan';


Vue.use(Vuex)

const vuexPersist = new VuexPersist({
    // key: 'webSmk', //developing
    key: 'smkn1mepanga.sch.id', //deployment
    storage: localStorage
})

export default new Vuex.Store({
    plugins: [vuexPersist.plugin],
    modules: {
        auth,
        news,
        constant,
        pendidikan,
        pendidikanDialog,
        addMode,
        spinner,
        jurusan
    },
})