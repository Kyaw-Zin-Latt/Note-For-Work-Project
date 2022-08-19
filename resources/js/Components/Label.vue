<template>
    <label :for="id" class="form-label">{{ label }}</label>
</template>

<script>
export default {
    name: "Label",
    props: ['label', 'id']
}
</script>

<style scoped>

</style>
