<template>
  <div>
    <h2>List of Cars</h2>
    <ul>
      <li v-for='car in cars'>
        <a href="#" @click.prevent='openCar(car.id)'>
          <h3>{{ car.title }}</h3>
        </a>
        <ul class='tag-list'>
          <li v-for='tag in car.tags'>{{ tag.name }}</li>
        </ul>

        <div v-if='getActiveCarId() === car.id'>
          <ul>
            <li>Mileage: {{ car.mileage }} miles/km</li>
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
  a {
    color: inherit;
  }

  .tag-list {
    list-style-type: none;

    li {
      display: inline-block;
      background: rgba(0, 0, 0, 0.2);
      color: #000;
      font-size: 11px;
      margin: 2px;
      padding: 2px 5px;
    }
  }
</style>
