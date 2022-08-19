<template>
    <InertiaLink :href="route(href)" class="text-decoration-none" preserve-state>
        <h6 :class="['mx-2 py-2-5 px-2 rounded mb-0  text-dark ', {'activeColor' : $page.url.startsWith(urlStart)}]">
            {{title}}
        </h6>
    </InertiaLink>
</template>

<script>
export default {
    name: "SubSideMenu",
    props: ["title", "isActive", "href", "urlStart"]
}
</script>

<style scoped>

</style>
