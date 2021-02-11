export default {
    namespaced: true,
    state: {
        loading: false,
    },
    mutations: {
        rubah: (state, content) => {
            state.loading = content
        }
    },
    actions: {
        set: ({ commit }, content) => {
            commit('rubah', content)
        }
    },
    getters: {
        loading: state => state.loading
    }
}