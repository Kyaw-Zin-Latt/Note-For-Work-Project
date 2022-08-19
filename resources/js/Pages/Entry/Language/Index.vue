<template>
    <Layout>
        <BreadCrumb text="Language" />

        <div class="text-end my-5">
            <Button @click="handleCreate" text="Add Language" href="language.create" icon="fa-plus" btn-type="btn-primary"/>
        </div>

        <Table>
            <template v-slot:thead>
                <tr class="text-white">
                    <th class="text-nowrap">#</th>
                    <th class="text-nowrap">{{ $t('lang_name_label') }}</th>
                    <th class="text-nowrap">{{ $t('symbol_label') }}</th>
                    <th class="text-nowrap">{{ $t('flag_label') }}</th>
                    <th class="text-nowrap">{{ $t('default_label') }}</th>
                    <th class="text-nowrap">{{ $t('active_label') }}</th>
                    <th class="text-nowrap">{{ $t('control_label') }}</th>
                    <th class="text-nowrap">{{ $t('lang_string_label') }}</th>
                    <th class="text-nowrap">{{ $t('date_label') }} / {{ $t('time_label') }}</th>
                </tr>
            </template>
            <template v-slot:tbody>
                <tr v-for="language in languages.data" :key="language.id">
                    <td>{{ language.id }}</td>
                    <td>{{ language.name }}</td>
                    <td>{{ language.symbol }}</td>
                    <td>
                       <img class="img-fluid" style="width: 30px;" :src="imgPath+'/language/'+language.image.img_path" alt="">
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input @change="handleDefault(language.id)" :checked=language.default class="form-check-input" type="checkbox" role="switch">
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input @change="handleStatus(language.id)" :checked=language.status class="form-check-input" type="checkbox" role="switch" >
                        </div>
                    </td>
                    <td class="">
                        <div class="">
                            <Button @click="handleDelete(language.id)" text="" icon="fa-fw fa-trash" btn-type="me-2 btn-sm btn-outline-danger"/>
                            <Button @click="handleEdit(language.id)" text="" icon="fa-fw fa-pen" btn-type="btn-sm btn-outline-warning"/>
                        </div>
                    </td>
                    <td>
                        <Button @click="handleLanguageString(language.id)" text="" icon="fa-fw fa-language" btn-type="btn-sm btn-outline-info"/>
                    </td>
                    <td>
                        <div class="">
                            <div class="">
                                <small>
                                    <i class="fa-solid fa-calendar text-primary"></i>
                                    {{ dataFormat(language.created_at, 'll') }}
                                </small>
                            </div>
                            <div class="">
                                <small>
                                    <i class="fa-solid fa-clock text-primary"></i>
                                    {{ dataFormat(language.created_at, 'LT') }}
                                </small>
                            </div>
                        </div>
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
    props : ['languages', 'imgPath'],
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
            Inertia.put(route('language.default',id));
        },
        handleStatus(id){
            Inertia.put(route('language.status',id))
        },
        handleDelete(id){
            Inertia.delete(route('language.destroy',id))
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
