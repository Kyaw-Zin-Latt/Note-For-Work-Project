<template>
    <div class="mb-4">
        <Label :label="label" :id="id" />
        <input :type="type" class="form-control" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :id="id" :placeholder="label">
        <small v-if="errors" class="text-danger fw-bolder">{{ errors }}</small>
    </div>
</template>

<script>
import Label from "../Components/Label.vue";
export default {
    name: "Input",
    components: {Label},
    props: ['label', 'id', 'type', 'modelValue', 'errors']
}
</script>

<style scoped>

</style>
