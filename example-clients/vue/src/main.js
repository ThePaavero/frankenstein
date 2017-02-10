import Vue from 'vue'
import store from './store'
import App from './App'

/* eslint-disable no-new */
new Vue({
  store,
  el: '#app',
  template: '<App/>',
  components: {App}
})
