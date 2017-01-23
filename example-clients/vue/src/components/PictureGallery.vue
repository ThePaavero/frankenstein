<template>
  <div>
    <ol>
      <li v-for='picture in pictures'>
        <img :src='picture.small' alt=''/>
      </li>
    </ol>
  </div>
</template>
<script>
  export default {
    props: ['pictures'],
    data() {
      return {}
    },
    methods: {},
    components: {}
  }
</script>
<style lang='scss' rel='stylesheet/scss' scoped>
</style>
