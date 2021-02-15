export default {
    namespaced: true,
    state: {
        jurusan: null,
    },
    mutations: {
        set: (state, content) => {
            state.jurusan = content
        }
    },
    actions: {
        set: ({ commit }, content) => {
            commit('set', content)
        }
    },
    getters: {
        jurusan: state => state.jurusan,
    }
}