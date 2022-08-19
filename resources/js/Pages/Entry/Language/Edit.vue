<template>
    <Layout>

        <!--     BreadCrumb-->
        <BreadCrumb text="Create Language">
            <BreadCrumbItem href="language.index" text="Language" />
        </BreadCrumb>

        <!--     Card-->
        <Card header="Add Language">
            <template v-slot:card-body>
                <form @submit.prevent="handleSubmit()">
                    <div class="row">
                        <div class="col-8">

                            <Input label="Language Name" :errors="errors.name" v-model="form.name" id="LanguageName" type="name" />

                            <Input label="Language Symbol" :errors="errors.symbol" v-model="form.symbol" id="LanguageSymbol" type="name" />

                            <CheckBox label="Status" v-model="form.status" id="Status" />


                        </div>
                        <div class="col-4">
                            <Label label="Country Flag" />
                            <input @change="onFileChange" ref="fileInput" type="file" @input="form.coverImg = $event.target.files[0]" class="d-none">
                            <img @click="clickPreview" :src="url" class="rounded shadow" style="height: 200px; width: 100%; object-fit: cover" alt="">
                            <small v-if="errors.coverImg" class="text-danger fw-bolder">{{ errors.coverImg }}</small>

                            <!--                         <progress v-if="form.progress" :value="form.progress.percentage" max="100">-->
                            <!--                             {{ form.progress.percentage }}%-->
                            <!--                         </progress>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="me-2">
                                <Button href="language.index" text="Cancel" btn-type="btn-outline-primary"/>
                            </div>
                            <div class="">
                                <Button text="Update" text-color="text-white" icon="fa-plus" btn-type="btn-primary"/>
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

export default {
    name: "Edit",
    components: {Label, Button, CheckBox, Card, Input, BreadCrumbItem, BreadCrumb},
    layout : Layout,
    props: ['errors', 'imgPath', 'language'],
    data() {
        return {
            form : useForm({
                name : this.language.name,
                symbol : this.language.symbol,
                status : this.language.status,
                coverImg : '',
                "_method": "put"
            }),
            url : this.imgPath+'/language/'+this.language.image.img_path,
        }
    },
    methods: {
        handleSubmit() {
            Inertia.post(route('language.update',this.language.id),this.form,{
                forceFormData: true,
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
