<template>
    <Layout>

        <!--     BreadCrumb-->
        <BreadCrumb :text="$t('project_detail_btn')">
            <BreadCrumbItem href="issue.index" :text="$t('issue_label')" />
        </BreadCrumb>

        <!--     Card-->
        <Card :header="$t('project_detail_btn')">
            <template v-slot:card-body>
                <h2>
                    {{ issue.name }}
                </h2>
                <h6 class="">
                    <span class="badge rounded-pill bg-info me-2">{{ issue.project.name }}</span>
                    <span class="badge rounded-pill bg-primary">{{ issue.team.name }}</span>
                </h6>
                <div class="mt-5">
                    <p v-html="issue.description"></p>

                </div>
            </template>

        </Card>

    </Layout>
</template>

<script>
import Layout from "../../../Components/Layout.vue";
import BreadCrumb from "../../../Components/BreadCrumb.vue";
import BreadCrumbItem from "../../../Components/SideBar/BreadCrumbItem.vue";
import Card from "../../../Components/Card.vue";
import Button from "../../../Components/Button.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import Label from "../../../Components/Label.vue";
import {trans} from "laravel-vue-i18n";

export default {
    name: "Edit",
    components: {Label, Button, Card, BreadCrumbItem, BreadCrumb},
    layout : Layout,
    props: ['errors', 'issue'],
    data() {
        return {

        }
    },
    methods: {


    },
}
</script>

<style scoped>

</style>
