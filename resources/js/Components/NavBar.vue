<template>
    <nav class="navbar bg-light py-1 shadow-sm position-sticky top-0" style="z-index: 1002;">
        <div class="container-fluid px-1">
<!--            <a class="navbar-brand">Navbar</a>-->
            <div>
                <form @submit.prevent="handleGlobalSearch" class="d-flex" role="search">
                    <input v-model="form.searchValue" class="form-control me-2"  placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="d-flex">
                <select @change="handleLanguage()" v-model="selectLanguage" class="form-select" aria-label="Default select example">
                    <option v-for="activeLanguage in activeLanguages" :key="activeLanguage.id" :value="activeLanguage.symbol">
                        {{ activeLanguage.name }}
                    </option>

                </select>
                <div class="btn-group">
                    <button type="button" class="btn border border-0 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img :src="imgPath+'/me.jpg'" class="profile-img border rounded-circle" alt="">

                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item" type="button">Profile</button></li>
                        <li>
                            <form @submit.prevent="logout">
                                <button class="dropdown-item" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import {loadLanguageAsync, getActiveLanguage} from "laravel-vue-i18n";
import {Inertia} from "@inertiajs/inertia";
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    name: "NavBar",
    props: ["imgPath", "activeLanguages"],
    data() {
        return {
            form : useForm({
                searchValue : '',
            }),
            selectLanguage: localStorage.getItem('lang') ? localStorage.getItem('lang') : getActiveLanguage(),
        }
    },
    computed: {
      // choosedLang(){
      //     if (localStorage.getItem('lang')){
      //       return this.selectLanguage = localStorage.getItem('lang')
      //     } else {
      //       return this.selectLanguage = getActiveLanguage()
      //     }
      // }
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
        handleLanguage() {
            const lang = this.selectLanguage;
            console.log(this.choosedLang);
            Inertia.get(route('language.changeLanguage',lang));
            localStorage.setItem('lang',lang);
            loadLanguageAsync(lang)
        },
        handleGlobalSearch() {
            Inertia.get(route('global.search', this.form));
        }
    },
}
</script>

<style scoped>

</style>
