<template>
    <Layout>

        <!--     BreadCrumb-->
        <BreadCrumb :text="$t('team_create_label')">
            <BreadCrumbItem href="team.index" :text="$t('team_label')" />
        </BreadCrumb>

        <!--     Card-->
        <Card :header="$t('team_create_label')">
            <template v-slot:card-body>
                <form @submit.prevent="handleSubmit()">
                <div class="row justify-content-between">
                    <div class="col-6">
                        <Input :label="$t('team_name')" :errors="errors.name" v-model="form.name" id="ProjectName" type="name" />
                    </div>
                    <CheckBox :label="$t('team_status')" v-model="form.status" id="Status" />



                </div>
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-end">
                    <div class="me-2">
                        <Button href="language.index" text="Cancel" btn-type="btn-outline-primary" />
                    </div>
                    <div class="">
                        <Button text="Save" text-color="text-white" icon="fa-plus" btn-type="btn-primary" />
                    </div>
                </div>
            </div>
        </form>
</template>

     </Card >

 </Layout >
</template >

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
import {trans} from "laravel-vue-i18n";


export default {
    name: "Create",
    components: {Label, Button, CheckBox, Card, Input, BreadCrumbItem, BreadCrumb},
    layout : Layout,
    props: ['errors', 'imgPath', 'status', 'projects'],
    data() {
        return {

            form : useForm({
                name : '',
                status: false
            }),

        }
    },

    methods: {
        handleSubmit() {
            Inertia.post(route('team.store'),this.form,{
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
    },
}
</script>

<style scoped>

</style>
