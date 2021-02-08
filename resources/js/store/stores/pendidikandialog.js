export default {
    namespaced: true,
    state: {
        showDialog: null,
    },
    mutations: {
        change: (state, content) => {
            state.showDialog = content
        }
    },
    actions: {
        set: ({ commit }, content) => {
            commit('change', content)
        }
    },
    getters: {
        showDialog: state => state.showDialog,
    }
}