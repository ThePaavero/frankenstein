<template>
  <div>
    <ol>
      <li v-for='picture in pictures'>
        <a :href='picture.medium' target='_blank'>
          <img :src='picture.small' alt=''/>
        </a>
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
