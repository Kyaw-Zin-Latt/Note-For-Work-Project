<template>
  <Head title="Welcome" />

  <div>
    <h1>Welcome Screen</h1>
    
  </div>
</template>

<style scoped>

</style>

<script>
import { defineComponent } from "vue"
import { loadLanguageAsync } from 'laravel-vue-i18n';
import { Head, Link } from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";

export default defineComponent({
  components: {
    Head,
    Link,
  },

  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  },
    methods: {
        change(lang) {
            loadLanguageAsync(lang)
        }
    },
})
</script>
