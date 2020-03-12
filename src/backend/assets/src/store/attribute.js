import Vue from 'vue';

export default {
    namespaced: true,

    state: {
        grid: null,
        model: {},
        list: []
    },

    getters: {
        grid (state) {
            return state.grid;
        },
        model (state) {
            return state.model;
        },
        list (state) {
            return state.list;
        }
    },

    mutations: {
        ['FETCH_ALL_SUCCESS'] (state, data) {
            state.grid = data;
        },
        ['FETCH_MODEL_SUCCESS'] (state, data) {
            state.model = data;
        },
        ['DELETE_MODEL_SUCCESS'] (state, data) {
            state.model = {};
        },
        ['FETCH_LIST_SUCCESS'] (state, data) {
            state.list = data;
        }
    },

    actions: {
        all ({state, commit, rootState}, params) {
            return Vue.axios.get('/catalog/api/v1/attribute/index', {params: params})
                .then(
                    response => commit('FETCH_ALL_SUCCESS', response.data),
                    error => {}
                )
        },

        find ({state, commit, rootState}, id) {
            return Vue.axios.get('/catalog/api/v1/attribute/find', {params: {id: id}})
                .then(
                    response => commit('FETCH_MODEL_SUCCESS', response.data),
                    error => {}
                )
        },

        save ({state, commit, rootState}, model) {
            return Vue.axios.post('/catalog/api/v1/attribute/save', model)
                .then(
                    response => commit('FETCH_MODEL_SUCCESS', response.data),
                    error => {}
                )
        },

        delete ({state, commit, rootState}, id) {
            return Vue.axios.post('/catalog/api/v1/attribute/delete', { id: id })
                .then(
                    response => commit('DELETE_MODEL_SUCCESS', response.data),
                    error => {}
                )
        },

        list ({state, commit, rootState}, params) {
            return Vue.axios.get('/catalog/api/v1/attribute/list', { params: params })
                .then(
                    response => commit('FETCH_LIST_SUCCESS', response.data),
                    error => {}
                )
        }

    }
};
