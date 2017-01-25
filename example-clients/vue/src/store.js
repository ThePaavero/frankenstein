import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
  cars: null,
  activeCarId: null,
  parts: null,
  activePartId: null,
  staff: null
}

const mutations = {
  updateStaff(state, staff) {
    state.staff = staff
  },
  updateCars(state, cars) {
    state.cars = cars
  },
  activateCarId(state, id) {
    state.activeCarId = state.activeCarId === id ? null : id
  },
  updateParts(state, parts) {
    state.parts = parts
  },
  activatePartId(state, id) {
    state.activePartId = state.activePartId === id ? null : id
  }
}

export default new Vuex.Store({
  state,
  mutations
})
