export default {
    namespaced: true,
    state: {
        guru_id: null,
    },
    mutations: {
        rubah: (state, content) => {
            state.guru_id = content
        }
    },
    actions: {
        set: ({ commit }, content) => {
            commit('rubah', content)
        }
    },
    getters: {
        mode: state => state.guru_id
    }
}