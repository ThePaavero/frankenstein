<template>
  <div>
    <h2>This is us! <a href='#' class='closer' @click.prevent='onClose()'>&#10006;</a></h2>
    <ul>
      <li v-for='person in staff'>
        <h4>{{ person.title }}</h4>
        <p>Phone: {{ person.phone }}</p>
        <p>Email: {{ person.email }}</p>
        <img :src='person.photo.medium' alt=''/>
      </li>
    </ul>
  </div>
</template>
<script>
  export default {
    props: ['staff', 'onClose'],
    components: {},
    data() {
      return {}
    },
    methods: {}
  }
</script>
<style lang='scss' rel='stylesheet/scss' scoped>
  .closer {
    color: red;
    text-decoration: none;
    font-size: 12px;
  }
</style>
