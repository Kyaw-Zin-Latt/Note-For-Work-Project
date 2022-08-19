<template>
   <InertiaLink :href="route(href)" class="text-decoration-none">
       <h6 :class="['mx-2 py-2-5 px-2 rounded mb-3 text-dark ', {'activeColor' : $page.url.startsWith(urlStart)}]">

           <i :class="['fa-solid me-2 ',icon, iconColor]"></i>
           {{title}}
       </h6>
   </InertiaLink>
</template>

<script>

export default {
    name: "SideMenu",
    props: ["title", "icon", "iconColor", "isActive", "href", 'urlStart']
}
</script>

<style scoped>

</style>
