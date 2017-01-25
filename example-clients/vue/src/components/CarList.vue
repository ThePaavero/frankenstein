<template>
  <div>
    <h2>List of Cars</h2>
    <ul>
      <li v-for='car in cars'>
        <a href="#" @click.prevent='openCar(car.id)'>
          <h3>{{ car.title }}</h3>
        </a>
        <div v-if='getActiveCarId() === car.id'>
          <ul>
            <li v-if='car.color'>Color: {{ car.color }}</li>
            <li>Price: {{ car.price }} €</li>
            <li>Registered: {{ car.registrationDate }} €</li>
          </ul>
          <div v-html='car.description'/>
          <div v-html='car.specs'/>
          <PictureGallery v-if='car.pictures[0].small' :pictures='car.pictures'/>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
  import PictureGallery from './PictureGallery.vue'

  export default {
    props: ['cars'],
    components: {
      PictureGallery
    },
    data() {
      return {}
    },
    methods: {
      getActiveCarId() {
        return this.$store.state.activeCarId
      },
      openCar(id) {
        this.$store.commit('activateCarId', id)
      }
    }
  }
</script>
<style lang='scss' rel='stylesheet/scss' scoped>
</style>
