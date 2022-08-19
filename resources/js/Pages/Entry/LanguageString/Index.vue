<template>
    <Layout :img-path="imgPath">
        <!--     BreadCrumb-->
        <BreadCrumb text="Language String">
            <BreadCrumbItem href="language.index" text="Language" />
        </BreadCrumb>

        <div class="text-end my-5">
            <Button @click="handleCreate" text="Add Language String" icon="fa-plus" btn-type="btn-primary"/>
        </div>

        <Table>
            <template v-slot:thead>
                <tr class="text-white">
                    <th>#</th>
                    <th class="">Language</th>
                    <th>Symbol</th>
                    <th>Key</th>
                    <th >Value</th>
                    <th>Control</th>
                </tr>
            </template>
            <template v-slot:tbody>
                <tr v-if="languageStrings.data.length > 0" v-for="languageString in languageStrings.data">
                    <td>
                        {{ languageString.id }}
                    </td>
                    <td>{{ languageString.language.name }}</td>
                    <td>{{ languageString.language.symbol }}</td>
                    <td>
                        {{ languageString.key }}
                    </td>
                    <td>{{ languageString.value }}</td>
                    <td>
                        <Button @click="handleLanguageString(language.id)" text="" icon="fa-fw fa-pen" btn-type="btn-sm btn-outline-info"/>
                    </td>

                </tr>
                <tr v-else>
                    <td colspan="6" class="text-primary text-center">There is no Language String.</td>
                </tr>
            </template>
        </Table>



    </Layout>
</template>

<script>
import Layout from "../../../Components/Layout.vue";
import BreadCrumb from "../../../Components/BreadCrumb.vue";
import Table from "../../../Components/Table.vue";
import Button from "../../../Components/Button.vue";
import moment from 'moment';
import {Inertia} from "@inertiajs/inertia";
import BreadCrumbItem from "../../../Components/SideBar/BreadCrumbItem.vue";

export default {
    name: "Index",
    components: {BreadCrumbItem, Button, Table, BreadCrumb},
    layout : Layout,
    props : ['languageStrings', 'imgPath', 'languageId'],
    data() {
        return {
            isDefault: ''
        }
    },
    methods: {

        handleCreate(){
            Inertia.get(route('language-string.create',this.languageId))
        },
        handleEdit(id){
            Inertia.get(route('language.edit',id))
        },
        handleLanguageString(id){
            Inertia.get(route('language-string.index',id))
        },


    },
}
</script>

<style scoped>

</style>
