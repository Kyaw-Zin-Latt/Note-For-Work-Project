<template>
    <div class="accordion-item">
        <h2 class="accordion-header" :id="['flush-heading'+dyNum]">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="['#flush-collapse'+dyNum]" aria-expanded="false" :aria-controls="['flush-collapse'+dyNum]">
                <h6 class="">
                    <i :class="['fa-solid me-2 ',icon, iconColor]"></i>
                    {{title}}
                </h6>
            </button>
        </h2>
        <div :id="['flush-collapse'+dyNum]" class="accordion-collapse collapse" :aria-labelledby="['flush-heading'+dyNum]" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body ps-3">
                <slot />
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "SideMenuDropDown",
    props: ["title", "icon", "iconColor", "dyNum"]
}
</script>

<style scoped>

</style>
