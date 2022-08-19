<template>
    <div class="overflow-x position-sticky top-0" style="height: 100vh !important; background-color: #6875f53d !important;">
        <div class="">
<!--            Logo Start-->
            <h3 class="py-3 text-center fw-bold mb-4">
                <i class="text-primary fa-solid fa-book-open"></i>
                Note For Work
            </h3>
<!--            Logo End-->


            <SideMenu href="dashboard" title="Dashboard" icon="fa-gauge-high" icon-color="text-success" url-start="/dashboard"/>

            <div class="accordion accordion-flush" id="accordionFlushExample">
                <SideMenuDropDown title="Entry" icon="fa-circle-plus" icon-color="text-primary" dy-num="One">
                    <SubSideMenu href="project.index" title="Project" url-start="/project" />
                </SideMenuDropDown>
                <SideMenuDropDown title="Setting" icon="fa-gear" icon-color="text-info" dy-num="Two">
                    <SubSideMenu href="language.index" title="Language" url-start="/language" />
                </SideMenuDropDown>
            </div>

            <div class="mx-3">
                <form @submit.prevent="logout">
                    <button class="btn btn-danger w-100" type="submit">
                        <i class="fa-solid fa-lock"></i>
                        Logout
                    </button>
                </form>
            </div>




        </div>
    </div>
</template>

<script>
import SideMenu from "./SideMenu.vue";
import SideMenuDropDown from "./SideMenuDropDown.vue";
import SubSideMenu from "./SubSideMenu.vue";
export default {
    name: "SideBar",
    components: {SubSideMenu, SideMenuDropDown, SideMenu}
}
</script>

<style scoped>

</style>
