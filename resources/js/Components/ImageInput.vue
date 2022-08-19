<template>
    <div class="mb-4">
        <Label :label="label" :id="id" />
        <input class="form-control" type="file" :id="id">
    </div>
</template>

<script>
import Label from "../Components/Label.vue";
export default {
    name: "ImageInput",
    components: {Label},
    props: ['label', 'id']
}
</script>

<style scoped>

</style>
