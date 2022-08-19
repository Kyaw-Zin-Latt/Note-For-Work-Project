<template>
    <div class="table-responsive animate__animated animate__fadeIn">
        <table class="table table-hover align-middle">
            <thead class="bg-primary">
                <slot name="thead"></slot>
            </thead>
            <tbody>
                <slot name="tbody"></slot>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Table"
}
</script>

<style scoped>

</style>
