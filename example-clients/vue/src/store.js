import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
  cars: null,
  activeCarId: null
}

const mutations = {
  updateCars(state, cars) {
    state.cars = cars
  },
  activateCarId(state, id) {
    state.activeCarId = state.activeCarId === id ? null : id
  }
}

export default new Vuex.Store({
  state,
  mutations
})
