<template>
    <li v-if="isActive" class="breadcrumb-item active" aria-current="page">{{ text }}</li>
<!--    <li v-else-if="isActiveWithId" class="breadcrumb-item active" aria-current="page">-->
<!--      <InertiaLink :href="route(href,id)">{{ text }}</InertiaLink>-->
<!--    </li>-->
  <li v-else-if="noInertiaLink" class="breadcrumb-item text-decoration-underline text-primary cursor-pointer" >
    {{ text }}
  </li>
  <li v-else class="breadcrumb-item"><InertiaLink :href="route(href)">{{ text }}</InertiaLink></li>

</template>

<script>
export default {
    name: "BreadCrumbItem",
    props: ["href", "text", "isActive", 'noInertiaLink']
}
</script>

<style scoped>

</style>
