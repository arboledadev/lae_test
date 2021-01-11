import Vue from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
Vue.use(VueAxios, axios)
import VueAxios from 'vue-axios'
Vue.config.productionTip = false
Vue.prototype.$api_key = '6367a50d-5da3-44a0-ae31-9142090862a4'
Vue.prototype.$base_url = 'http://localhost:8888/lae/test/api/'
/* Vue.prototype.$base_url = 'http://laetest.arboledadev.com/api/' */
new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
