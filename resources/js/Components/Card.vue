<template>
    <div class="card animate__animated animate__fadeIn">
        <h5 class="card-header bg-primary text-white">{{header}}</h5>
        <div class="card-body">
            <slot name="card-body">

            </slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Card",
    props: ['header']
}
</script>

<style scoped>

</style>
