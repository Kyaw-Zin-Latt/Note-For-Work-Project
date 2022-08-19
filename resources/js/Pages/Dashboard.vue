<template>
  <Layout :img-path="imgPath">
      <h1>{{ $t('dashboard') }}</h1>

  </Layout>
</template>

<script>
import Layout from "../Components/Layout.vue";

export default {
    name: "Dashboard",
    props: ['imgPath'],
    layout : Layout,
}
</script>

<style scoped>

</style>
