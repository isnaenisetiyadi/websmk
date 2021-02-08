export default {
    namespaced: true,
    state: {
        post: {}
    },
    mutations: {
        set: (state, content) => {
            state.post = content
        }
    },
    actions: {
        set: ({ commit }, content) => {
            commit('set', content)
        }
    },
    getters: {
        post: state => state.post,
    }
}