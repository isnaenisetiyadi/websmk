export default {
    namespaced: true,
    state: {
        user: null,
    },
    mutations: {
        set: (state, content) => {
            state.user = content
        }
    },
    actions: {
        set: ({ commit }, content) => {
            commit('set', content)
        }
    },
    getters: {
        user: state => state.user,
        // not_login: state => state.user.length == 0,
        // super_user: state => Object.keys(state.user).roles === "SUPER_USER",
        // admin: state => Object.keys(state.user).roles === "ADMIN",
        // guest: state => Object.keys(state.user).roles === "GUEST",


    }
}