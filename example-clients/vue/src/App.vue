<template>
  <div id='app'>
    <h1>Cars and Parts for Sale!</h1>
    <CarList v-if='this.$store.state.cars' :cars='this.$store.state.cars'/>
    <div v-else>
      <p>Loading cars, just a second...</p>
    </div>
    <PartList v-if='this.$store.state.parts' :parts='this.$store.state.parts'/>
    <div v-else>
      <p>Loading parts, just a second...</p>
    </div>
  </div>
</template>

<script>
  import CarList from './components/CarList.vue'
  import PartList from './components/PartList.vue'
  import axios from 'axios'

  export default {
    name: 'app',
    components: {
      CarList,
      PartList,
    },
    mounted() {
      this.$router.push('/')
      this.getCars()
        .then((cars) => {
          this.$store.commit('updateCars', cars)
        })
        .catch((err) => {
          console.error(err)
          window.alert('Error: Could not fetch car list from server.')
        })
      this.getParts()
        .then((parts) => {
          this.$store.commit('updateParts', parts)
        })
        .catch((err) => {
          console.error(err)
          window.alert('Error: Could not fetch part list from server.')
        })
    },
    methods: {
      goHome() {
        this.$router.push('/')
      },
      getCars() {
        return new Promise((resolve, reject) => {
          axios.get('http://frankenstein-demo.dev/?json=cars.getAll')
            .then((response) => {
              resolve(response.data.cars)
            })
            .catch((err) => {
              reject(err)
            })
        })
      },
      getParts() {
        return new Promise((resolve, reject) => {
          axios.get('http://frankenstein-demo.dev/?json=parts.getAll')
            .then((response) => {
              resolve(response.data.parts)
            })
            .catch((err) => {
              reject(err)
            })
        })
      }
    }
  }
</script>

<style lang='scss' rel='stylesheet/scss'>
  #app {
    font-family: 'Open Sans', sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: left;
    color: #000;
    font-size: 2vw;
    padding: 5vh 5vw;

    @media screen and (max-width: 800px) {
      font-size: 16px;
    }
  }

  h1 {
    font-size: 4vw;
    margin-bottom: 4vh;

    @media screen and (max-width: 800px) {
      font-size: 30px;
    }
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity 1s
  }

  .fade-enter, .fade-leave-active {
    opacity: 0
  }
</style>
