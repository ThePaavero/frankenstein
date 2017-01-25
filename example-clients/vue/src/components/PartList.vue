<template>
  <div>
    <h2>List of Parts</h2>
    <ul>
      <li v-for='part in parts'>
        <a href="#" @click.prevent='openPart(part.id)'>
          <h3>{{ part.title }}</h3>
        </a>
        <ul class='tag-list'>
          <li v-for='tag in part.typeTags'>{{ tag }}</li>
        </ul>
        <div v-if='getActivePartId() === part.id'>
          <p v-html='part.description'></p>
          <p v-html='part.specs'></p>
          <p>Price: {{ part.price }} €</p>
          <PictureGallery v-if='part.pictures[0].small' :pictures='part.pictures'/>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
  import PictureGallery from './PictureGallery.vue'

  export default {
    props: ['parts'],
    components: {
      PictureGallery
    },
    data() {
      return {}
    },
    methods: {
      getActivePartId() {
        return this.$store.state.activePartId
      },
      openPart(id) {
        this.$store.commit('activatePartId', id)
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
