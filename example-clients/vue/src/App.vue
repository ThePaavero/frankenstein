<template>
  <div id='app'>
    <h1>Cars and Parts for Sale!</h1>
    <CarList v-if='this.$store.cars'/>
  </div>
</template>

<script>
  import CarList from './components/CarList.vue'
  import axios from 'axios'

  export default {
    name: 'app',
    components: {
      CarList
    },
    mounted() {
      this.$router.push('/')
      this.getCars()
    },
    methods: {
      goHome() {
        this.$router.push('/')
      },
      getCars() {
        return new Promise((resolve, reject) => {
          axios.get('http://frankenstein-demo.dev:8000/?json=cars.getWithTaxonomies')
            .then((response) => {
              resolve(response.data)
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
