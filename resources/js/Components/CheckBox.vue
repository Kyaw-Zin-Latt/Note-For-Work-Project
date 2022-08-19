<template>
   <div class="mb-4">
       <Label :label="label" :id="id" />
       <div class="form-check">
           <input class="form-check-input" type="checkbox" :checked="modelValue" @input="$emit('update:modelValue', $event.target.checked)" :id="id">
           <label class="form-check-label" :for="id">
               {{ label }}
           </label>
       </div>
   </div>
</template>

<script>
import Label from "../Components/Label.vue";
export default {
    name: "CheckBox",
    components: {Label},
    props: ['label', 'id', 'modelValue']
}
</script>

<style scoped>

</style>
