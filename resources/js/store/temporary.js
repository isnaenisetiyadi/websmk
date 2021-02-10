import Vue from 'vue';
import Vuex from 'vuex';

import constant from './stores/constant';

// import example from './module-example'

Vue.use(Vuex)

// export default function( /* { ssrContext } */ ) {
//     const temporary = new Vuex.Store({
//         modules: {
//             constant
//         },

//         // enable strict mode (adds overhead!)
//         // for dev mode only
//         strict: process.env.DEV
//     })

//     return temporary
// }

export default new Vuex.Store({
    modules: {
        constant,
    },
})