import client from '../utils/client';

export default (url, additional = {}) => ({
  namespaced: true,
  state() {
    return {
      data: {},
      error: {},
      isFetched: false,
      isFetching: false,
      ...(typeof additional.state === 'function' ? additional.state() : {}),
    };
  },
  getters: {
    getData: state => state.data,
    getError: state => state.error,
    getIsFetched: state => state.isFetched,
    getIsFetching: state => state.isFetching,
    ...additional.getters,
  },
  mutations: {
    setData(state, payload) {
      state.data = payload;
    },
    setElementById(state, payload) {
      state.data = state.data
        .map(element => (element.id === payload.id
          ? payload
          : element
        ));
    },
    setError(state, payload) {
      state.error = payload;
    },
    setIsFetched(state, payload) {
      state.isFetched = payload;
    },
    setIsFetching(state, payload) {
      state.isFetching = payload;
    },
    ...additional.mutations,
  },
  actions: {
    fetchData({ state, commit }, payload = {}) {
      return new Promise((resolve, reject) => {
        commit('setIsFetched', false);
        commit('setIsFetching', true);
        commit('setError', {});
        client.get(
          url,
          { ...payload.query },
        ).then(
          (response) => {
            const data = response.data.data === undefined ? response.data : response.data.data;
            if (typeof state.data === typeof data && data !== null) {
              commit('setData', data);
              commit('setIsFetched', true);
            } else {
              throw new TypeError(`Response and state types inconsistent for '${url}'`);
            }
            commit('setIsFetching', false);
            resolve(response);
          },
          (error) => {
            if (error.response) {
              commit('setError', error.response.data);
              commit('setIsFetched', false);
              commit('setIsFetching', false);
            } else {
              throw error;
            }
            reject(error);
          },
        );
      });
    },
    updateItem({ commit }, payload) {
      commit('setElementById', payload);
    },
    ...additional.actions,
  },
});
