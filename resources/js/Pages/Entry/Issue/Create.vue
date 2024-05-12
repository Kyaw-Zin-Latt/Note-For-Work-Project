<template>
    <Layout>

        <!--     BreadCrumb-->
        <BreadCrumb :text="$t('issue_create_label')">
            <BreadCrumbItem href="issue.index" :text="$t('issue_label')" />
        </BreadCrumb>

        <!--     Card-->
        <Card :header="$t('issue_create_label')">
            <template v-slot:card-body>
                <form @submit.prevent="handleSubmit()">
                <div class="row justify-content-between">
                    <div class="col-12">
                        <Input :label="$t('issue_name')" :errors="errors.name" v-model="form.name" id="ProjectName" type="name" />
                    </div>

                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-6">
                                <Label :label="$t('project_name')"/>
                                <select v-model="form.project_id" class="form-select" aria-label="Default select example">
                                    <option :value="form.project_id === null && null">Open this select menu</option>
                                    <option v-for="project in projects" :key="project.id" :value=project.id>
                                        {{ project.name }}
                                    </option>
                                </select>
                                <small v-if="errors.project_id" class="text-danger fw-bolder">{{ errors.project_id }}</small>
                            </div>

                            <div class="col-6">
                                <Label :label="$t('team_name')"/>
                                <select v-model="form.team_id" class="form-select" aria-label="Default select example">
                                    <option :value="form.team_id === null && null">Open this select menu</option>
                                    <option v-for="team in teams" :key="team.id" :value=team.id>
                                        {{ team.name }}
                                    </option>
                                </select>
                                <small v-if="errors.team_id" class="text-danger fw-bolder">{{ errors.team_id }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <Label :label="$t('issue_description')"/>
                        <div id="app">
                            <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
                        </div>
                    </div>


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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
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
    props: ['errors', 'imgPath', 'status', 'projects', 'teams'],
    data() {
        return {
            editor: ClassicEditor,
            editorData: '<p>Content of the editor.</p>',
            editorConfig: {

            },
            form : useForm({
                name : '',
                description: '',
                project_id: null,
                team_id: null,
            }),
            url : this.imgPath+'/placeholder.jpg',
        }
    },

    methods: {
        handleSubmit() {
            Inertia.post(route('issue.store'),this.form,{
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

        clickPreview() {
            this.$refs.fileInput.click();
        },
        onFileChange(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },

        createImage(files) {
            let vm = this;
            for (let index = 0; index < files.length; index++) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    const imageUrl = event.target.result;
                    vm.galleryUrls.push(imageUrl);
                }
                vm.form.images.push(files[index]);
                reader.readAsDataURL(files[index]);
            }
        },
        removeImage(index) {
            this.galleryUrls.splice(index, 1)
        }

    },
}
</script>

<style scoped>

</style>
