<template>
    <Layout>

        <!--     BreadCrumb-->
        <BreadCrumb :text="$t('project_add_btn')">
            <BreadCrumbItem href="project.index" :text="$t('project_label')" />
        </BreadCrumb>

        <!--     Card-->
        <Card :header="$t('project_edit_label')">
            <template v-slot:card-body>
                <form @submit.prevent="handleSubmit()">
                    <div class="row justify-content-between">
                        <div class="col-7">

                            <Input :label="$t('project_name')" :errors="errors.name" v-model="form.name" id="ProjectName" type="name" />

                            <CheckBox :label="$t('project_status')" v-model="form.status" id="Status" />

                        </div>
                        <div class="col-4">
                            <Label class="d-block mb-3" :label="$t('project_logo')" />
                            <input @change="onFileChange" ref="fileInput" type="file" @input="form.coverImg = $event.target.files[0]" class="d-none">
                            <img @click="clickPreview" :src="url" class="rounded-circle shadow" style="height: 150px; width: 150px; object-fit: cover" alt="">
                            <small v-if="errors.coverImg" class="text-danger d-block mt-2 fw-bolder">{{ errors.coverImg }}</small>

                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="me-2">
                                <Button href="language.index" :text="$t('cancel_btn')" btn-type="btn-outline-primary"/>
                            </div>
                            <div class="">
                                <Button :text="$t('update_btn')" text-color="text-white" icon="fa-plus" btn-type="btn-primary"/>
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
import {trans} from "laravel-vue-i18n";

export default {
    name: "Edit",
    components: {Label, Button, CheckBox, Card, Input, BreadCrumbItem, BreadCrumb},
    layout : Layout,
    props: ['errors', 'imgPath', 'project', 'status'],
    data() {
        return {
            form : useForm({
                name : this.project.name,
                status : this.project.status,
                coverImg : '',
                "_method": "put"
            }),
            url : this.imgPath+'/project/'+this.project.image.img_path,
        }
    },
    methods: {
        handleSubmit() {
            Inertia.post(route('project.update',this.project.id),this.form,{
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
