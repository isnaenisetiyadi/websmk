export default {
    namespaced: true,
    state: {
        pendidikans: {},
    },
    mutations: {
        insert: (state, content) => {
            state.pendidikans.push({
                id: content.id,
                user_id: content.user_id,
                guru_id: content.guru_id,
                jenjang: content.jenjang,
                sekolah: content.sekolah,
                tahun_masuk: content.tahun_masuk,
                tahun_lulus: content.tahun_lulus

            })
        },
        update: (state, content) => {
            let idx = state.pendidikans.indexOf(content);
            state.pendidikans.splice(idx, 1, {
                id: content.id,
                user_id: content.user_id,
                guru_id: content.guru_id,
                jenjang: content.jenjang,
                sekolah: content.sekolah,
                tahun_masuk: content.tahun_masuk,
                tahun_lulus: content.tahun_lulus
            });
        },
        destroy: (state, content) => {
            let idx = state.pendidikans.indexOf(content);
            state.pendidikans.splice(idx, 1);
        },
        set: (state, content) => {
            state.pendidikans = content
        }
    },
    actions: {
        add: ({ state, commit }, content) => {
            let pendidikanItem = state.pendidikans.find(item => item.id === content.id)
            if (!pendidikanItem) {
                commit('insert', content)
            } else {
                commit('update', content)
            }
        },
        remove: ({ state, commit }, content) => {
            let pendidikanItem = state.pendidikans.find(item => item.id === content.id)
            if (pendidikanItem) {
                commit('destroy', pendidikanItem)
            }
        },
        set: ({ commit }, content) => {
            commit('set', content)
        }
    },
    getters: {
        pendidikans: state => state.pendidikans,

    }
}