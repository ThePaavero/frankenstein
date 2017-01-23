<template>
  <div>
    <h2>List of Cars</h2>
    <ul>
      <li v-for='car in cars'>
        <h3>{{ car.post.post_title }}</h3>
        <ul>
          <li>Price: {{ car.meta.price }} €</li>
          <li>Registered: {{ car.meta.registered_date }} €</li>
        </ul>
        <p>
          {{ car.meta.description }}
        </p>
        <p>
          {{ car.meta.technical_specs }}
        </p>
        <PictureGallery v-if='car.pictures[0].small' :pictures='car.pictures'/>
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
    methods: {}
  }
</script>
<style lang='scss' rel='stylesheet/scss' scoped>
</style>
