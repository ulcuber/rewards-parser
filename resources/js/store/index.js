import Vue from 'vue';
import Vuex from 'vuex';

import Data from './Data';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    rewards: Data('/api/rewards'),
  },
});
