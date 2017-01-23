<template>
  <div>
    <h2>List of Cars</h2>
    <ul>
      <li v-for='car in cars'>
        <a href="#" @click.prevent='openCar(car.post.ID)'>
          <h3>{{ car.post.post_title }}</h3>
        </a>
        <div v-if='getActiveCarId() === car.post.ID'>
          <ul>
            <li>Price: {{ car.meta.price }} €</li>
            <li>Registered: {{ car.meta.registered_date }} €</li>
          </ul>
          <div v-html='car.meta.description'/>
          <div v-html='car.meta.technical_specs'/>
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
