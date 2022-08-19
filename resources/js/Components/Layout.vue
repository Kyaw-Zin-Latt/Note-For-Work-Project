<template>
  <div class="row g-0">
      <div class="col-3">
          <SideBar />
      </div>
      <div class="col-9">
          <NavBar :img-path="imgPath" :active-languages="activeLanguages" />
          <div class="px-2 py-4">
              <slot />
          </div>
      </div>
  </div>
</template>

<script>
import SideBar from "./SideBar/SideBar.vue";
import NavBar from "./NavBar.vue";
export default {
    name: "Layout",
    props: ['imgPath', 'activeLanguages'],
    components: {NavBar, SideBar}
}
</script>

<style scoped>

</style>
