<template>
    <Layout>
        <BreadCrumb :text="$t('project_label')" />

        <div class="text-end my-5">
            <Button @click="handleCreate" :text="$t('project_add_btn')" href="project.create" icon="fa-plus" btn-type="btn-primary"/>
        </div>

        <Table>
            <template v-slot:thead>
                <tr class="text-white">
                    <th class="text-nowrap">#</th>
                    <th class="text-nowrap">{{ $t('project_name_label') }}</th>
                    <th class="text-nowrap">{{ $t('project_logo_label') }}</th>
                    <th class="text-nowrap">{{ $t('runing_label') }}</th>
                    <th class="text-nowrap">{{ $t('control_label') }}</th>
                    <th class="text-nowrap">{{ $t('date_label') }} / {{ $t('time_label') }}</th>
                </tr>
            </template>
            <template v-slot:tbody>
                <tr v-if="projects.data.length > 0" v-for="project in projects.data" :key="project.id">
                    <td>{{ project.id }}</td>
                    <td>{{ project.name }}</td>
                    <td>
                       <img class="img-fluid rounded-circle" style="width: 50px;" :src="imgPath+'/project/'+project.image.img_path" alt="">
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input @change="handleStatus(project.id)" :checked=project.status class="form-check-input" type="checkbox" role="switch" >
                        </div>
                    </td>
                    <td class="">
                        <div class="">
                            <Button @click="handleDelete(project.id)" text="" icon="fa-fw fa-trash" btn-type="me-2 btn-sm btn-outline-danger"/>
                            <Button @click="handleEdit(project.id)" text="" icon="fa-fw fa-pen" btn-type="btn-sm btn-outline-warning"/>
                        </div>
                    </td>
                    <td>
                        <div class="">
                            <div class="">
                                <small>
                                    <i class="fa-solid fa-calendar text-primary"></i>
                                    {{ dataFormat(project.created_at, 'll') }}
                                </small>
                            </div>
                            <div class="">
                                <small>
                                    <i class="fa-solid fa-clock text-primary"></i>
                                    {{ dataFormat(project.created_at, 'LT') }}
                                </small>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="6" class="text-center text-primary fw-bolder">
                        There is no Project
                    </td>
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

export default {
    name: "Index",
    components: {Button, Table, BreadCrumb},
    layout : Layout,
    props : ['projects', 'imgPath'],
    data() {
        return {
            isDefault: ''
        }
    },
    methods: {
        dataFormat(date, format){
            return moment(date).format(format);
        },
        handleDefault(id){
            Inertia.put(route('project.default',id));
        },
        handleStatus(id){
            Inertia.put(route('project.status',id))
        },
        handleDelete(id){
            Inertia.delete(route('project.destroy',id))
        },
        handleEdit(id){
            Inertia.get(route('project.edit',id))
        },
        handleCreate(){
            Inertia.get(route('project.create'))
        },

    },
}
</script>

<style scoped>

</style>
