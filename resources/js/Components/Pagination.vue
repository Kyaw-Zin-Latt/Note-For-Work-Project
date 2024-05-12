<template>
    <nav aria-label="...">
        <ul class="pagination mb-0">
            <li v-for="link in links" :class="[
                'page-item',
                link.url === null && 'disabled',
                link.active && 'active' ]
            ">
                <InertiaLink class="page-link" :href="link.url" v-html=" link.label === 'pagination.next' ? '>>' : ( link.label === 'pagination.previous' ? '<<' : link.label) " ></InertiaLink>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "Pagination",
    props: ['links']
}
</script>

<style scoped>

</style>
