import Vue from 'vue';

import jquery from 'jquery';
import 'bootstrap';

import store from './store';
import App from './components/App';

window.$ = jquery;
window.jQuery = jquery;

new Vue({
  store,
  render: h => h(App),
}).$mount('#app');
