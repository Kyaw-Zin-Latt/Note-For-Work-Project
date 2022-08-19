<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <BreadCrumbItem href="dashboard" text="Dashboard" />
            <slot />
            <BreadCrumbItem :text="text" is-active="true"/>
        </ol>
    </nav>
</template>

<script>
import BreadCrumbItem from "./SideBar/BreadCrumbItem.vue";
export default {
    name: "BreadCrumb",
    components: {BreadCrumbItem},
    props: ["last", "href", "text"]
}
</script>

<style scoped>

</style>
