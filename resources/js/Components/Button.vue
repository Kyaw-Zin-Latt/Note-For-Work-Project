<template>

    <InertiaLink v-if="href" :href="route(href)">
        <button :class="['btn', btnType, textColor]">
            <i :class="['fa-solid', icon]"></i>
            {{ text }}
        </button>
    </InertiaLink>

    <button v-else :class="['btn', btnType, textColor]">
        <i :class="['fa-solid', icon]"></i>
        {{ text }}
    </button>

</template>

<script>
export default {
    name: "Button",
    props: ['text', 'icon', 'href', 'btnType', 'textColor']
}
</script>

<style scoped>

</style>
