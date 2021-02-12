export default {
    namespaced: true,
    state: {
        urlImage: "",
        // urlImage: "http://127.0.0.1:8001/images",

    },
    mutations: {
        add: (state, content) => {
            state.urlImage = content
        }
    },
    actions: {
        set: ({ commit }, content) => {
            commit('add', content)
        }
    },
    getters: {
        urlImage: state => state.urlImage
    }
}