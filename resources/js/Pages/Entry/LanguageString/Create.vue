<template>
 <Layout :img-path="imgPath">

<!--     BreadCrumb-->
     <BreadCrumb text="Create Language String">
         <BreadCrumbItem href="language.index" text="Language" />
         <BreadCrumbItem @click="toLanguageStringIndex" no-inertia-link="1" text="Language String" />
     </BreadCrumb>

<!--     Card-->
     <Card header="Add Language String">
         <template v-slot:card-body>
             <form @submit.prevent="handleSubmit()">
                 <div class="row">
                     <div class="col-4">
                         <Input label="Language Key" :errors="errors.key" v-model="form.key" id="LanguageKey" type="name" />
                     </div>
                     <div class="col-8">
                         <Input label="Language String" :errors="errors.string" v-model="form.string" id="LanguageString" type="name" />
                     </div>

                 </div>
                 <div class="row">
                     <div class="col-12 d-flex justify-content-end">
                         <div class="me-2">
                             <Button href="language.index" text="Cancel" btn-type="btn-outline-primary"/>
                         </div>
                         <div class="">
                             <Button text="Save" text-color="text-white" icon="fa-plus" btn-type="btn-primary"/>
                         </div>
                     </div>
                 </div>
             </form>
         </template>

     </Card>

 </Layout>
</template>

<script>
import Layout from "../../../Components/Layout.vue";
import BreadCrumb from "../../../Components/BreadCrumb.vue";
import BreadCrumbItem from "../../../Components/SideBar/BreadCrumbItem.vue";
import Input from "../../../Components/Input.vue";
import Card from "../../../Components/Card.vue";
import CheckBox from "../../../Components/CheckBox.vue";
import Button from "../../../Components/Button.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import Label from "../../../Components/Label.vue";
import { trans } from 'laravel-vue-i18n';

export default {
    name: "Create",
    components: {Label, Button, CheckBox, Card, Input, BreadCrumbItem, BreadCrumb},
    layout : Layout,
    props: ['errors', 'imgPath', 'language', 'status'],
    data() {
        return {
            form : useForm({
                key : '',
                string : '',
                language_id: this.language.id
            }),
        }
    },
    methods: {
        handleSubmit() {
            Inertia.post(route('language-string.store',this.language.id),this.form, {
                forceFormData: true,
                onSuccess: () => {
                    console.log("created");
                    const Toast = this.$swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', this.$swal.stopTimer)
                            toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                        }
                        })

                        Toast.fire({
                        icon: this.status.flag,
                        title: trans(this.status.msg)
                    })
                }
            });
        },
        toLanguageStringIndex(){
            Inertia.get(route('language-string.index',this.language.id))
        },

    },
}
</script>

<style scoped>

</style>
