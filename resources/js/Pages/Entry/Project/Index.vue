<template>
    <Layout>
        <BreadCrumb :text="$t('project_label')" />

        <div class="d-flex">

        </div>

        <div :class="['text-end', !isShowSearchInputs && 'my-5']">
<!--            <a :href="route('project.exportCSV')">-->
<!--                <Button :text="$t('Export')" icon="fa-file-csv" btn-type="btn-primary me-1" />-->
<!--            </a>-->
            <button v-if="isShowClearSearchBtn" type="button" class="btn btn-link me-1" @click="handleClearSearch">
                Clear Filter
            </button>
            <button v-if="isShowSearchBtn" type="button" class="btn btn-primary me-1" @click="handleSearch">
                <i class="fa-solid fa-search"></i>
            </button>
            <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                <i class="fa-solid fa-cloud-arrow-up"></i>
            </button>

            <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa-solid fa-cloud-arrow-down fa-fw"></i>
            </button>

            <Button @click="handlePdf" :text="$t('')" icon="fa-file-pdf fa-fw" btn-type="btn-primary me-1"/>
            <Button @click="handleCreate" :text="$t('project_add_btn')" href="project.create" icon="fa-plus" btn-type="btn-primary"/>
        </div>

        <div v-if="isShowSearchInputs" class="d-flex mt-2 mb-5">
            <div class="col-3 me-2">
                <input placeholder="Search Something" type="search" v-model="params.searchKey" class="form-control">
            </div>
            <div class="col-3">
                <select v-model="params.status" class="form-select" aria-label="Default select example">
                    <option value="default">Select Status</option>
                    <option value="1">Publish</option>
                    <option value="0">unPublish</option>
                </select>
            </div>
        </div>


        <!-- Import Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModal1Label">Choose Format To Export</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="importCSV" id="importForm" class="d-flex">
                            <input type="file" @input="form2.csvImportFile = $event.target.files[0]" class="form-control">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button form="importForm" type="submit" class="btn btn-primary" data-bs-dismiss="modal">Import</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Export Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Choose Format To Export</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="d-flex">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" value="xlsx" v-model="form.extension" name="flexRadioDefault" id="XLSX">
                                <label class="form-check-label" for="XLSX">
                                    XLSX
                                </label>
                            </div>
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" value="csv" v-model="form.extension" name="flexRadioDefault" id="CSV">
                                <label class="form-check-label" for="CSV">
                                    CSV
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="html" v-model="form.extension" name="flexRadioDefault" id="HTML">
                                <label class="form-check-label" for="HTML">
                                    HTML
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a :href="route('project.exportCSV',this.form.extension)">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Export</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <Table>
            <template v-slot:thead>
                <tr class="text-white">
                    <th class="text-nowrap">#</th>
                    <th class="text-nowrap">
                        {{ $t('project_name_label') }}
                        <i @click="handleSort('name')" :class="['text-black ms-1 fa-solid', nameIcon]"></i>
                    </th>
                    <th class="text-nowrap">{{ $t('project_logo_label') }}</th>
                    <th class="text-nowrap">
                        {{ $t('runing_label') }}
                        <i @click="handleSort('status')" :class="['text-black ms-1 fa-solid', statusIcon]"></i>
                    </th>
                    <th class="text-nowrap">{{ $t('control_label') }}</th>
                    <th class="text-nowrap">
                        {{ $t('date_label') }} / {{ $t('time_label') }}
                        <i @click="handleSort('created_at')" :class="['text-black ms-1 fa-solid', createdAtIcon]"></i>
                    </th>
                </tr>
            </template>
            <template v-slot:tbody>
                <tr v-if="projects.data.length > 0" v-for="project in projects.data" :key="project.id">
                    <td>{{ project.id }}</td>
                    <td>{{ project.name }}</td>
                    <td>
<!--                       <img class="img-fluid rounded-circle" style="width: 50px;" :src="imgPath+'/project/'+project.image ? project.image.img_path : '' " alt="">-->
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

        <div class="d-flex justify-content-between align-items-center">
            <div class="">
                <select v-model="params.perPage" class="form-select" aria-label="Default select example">
                    <option value="2">2</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                </select>
            </div>
            <div class="">
                <Pagination :links="projects.links" />
            </div>
            <div class="">
                <p class="fw-bolder mb-0">
                    Total : <span class="text-primary">{{ projects.total }}</span>
                </p>
            </div>
        </div>


    </Layout>
</template>

<script>
import Layout from "../../../Components/Layout.vue";
import BreadCrumb from "../../../Components/BreadCrumb.vue";
import Table from "../../../Components/Table.vue";
import Button from "../../../Components/Button.vue";
import moment from 'moment';
import {Inertia} from "@inertiajs/inertia";
import {trans} from "laravel-vue-i18n";
import Pagination from "../../../Components/Pagination.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {debounce} from "lodash";

export default {
    name: "Index",
    components: {Pagination, Button, Table, BreadCrumb},
    layout : Layout,
    props : ['projects', 'imgPath', 'status', 'filteredValue'],
    data() {
        return {
            isDefault: '',
            params: {
                searchKey : this.filteredValue.searchKey,
                field: this.filteredValue.field,
                direction: this.filteredValue.direction,
                status: ('status' in this.filteredValue) ? this.filteredValue.status : 'default',
                perPage: '10'

            },
            isShowSearchInputs : false,
            isShowClearSearchBtn : false,
            isShowSearchBtn : true,
            form : useForm({
               extension : "xlsx"
            }),
            form2 : useForm({
                csvImportFile : '',
            })
        }
    },
    created() {
      if (this.filteredValue === undefined || this.filteredValue === 0){
          this.isShowSearchInputs = true;
          this.isShowClearSearchBtn = true;
          this.isShowSearchBtn = false;
      }
    },
    watch: {
        params: {
            handler : debounce(function (val){
                console.log(val);
                    Inertia.get(route('project.index'), this.params, {
                        replace : true,
                        preserveState: true
                    })

            }, 100),
            deep: true
        }
    },
    computed: {
        nameIcon() {
            if (this.params.field === 'name'){
                return this.params.direction === "asc" ? this.iconName = 'fa-sort-up' : this.iconName = 'fa-sort-down'
            } else {
                return this.iconName = 'fa-sort'
            }
        },
        statusIcon() {
            if (this.params.field === 'status'){
                return this.params.direction === "asc" ? this.iconName = 'fa-sort-up' : this.iconName = 'fa-sort-down'
            } else {
                return this.iconName = 'fa-sort'
            }
        },
        createdAtIcon() {
            if (this.params.field === 'created_at'){
                return this.params.direction === "asc" ? this.iconName = 'fa-sort-up' : this.iconName = 'fa-sort-down'
            } else {
                return this.iconName = 'fa-sort'
            }
        }
    },
    methods: {
        handleSearch(){
            this.isShowSearchInputs = true;
            this.isShowClearSearchBtn = true;
            this.isShowSearchBtn = false;
        },
        handleClearSearch(){
            this.isShowSearchInputs = false;
            this.isShowClearSearchBtn = false;
            this.isShowSearchBtn = true;
        },
        dataFormat(date, format){
            return moment(date).format(format);
        },
        handleDefault(id){
            Inertia.put(route('project.default',id));
        },
        handleStatus(id){
            Inertia.put(route('project.status',id),'',{
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
            })
        },
        handleDelete(id){
            Inertia.delete(route('project.destroy',id),{
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
            })
        },
        handleEdit(id){
            Inertia.get(route('project.edit',id))
        },
        handleCreate(){
            Inertia.get(route('project.create'))
        },
        handlePdf(){
            Inertia.get(route('project.exportPdf'))
        },
        importCSV(){
            Inertia.post(route('project.importCSV'),this.form2,{
                forceFormData: true,
                // onSuccess: () => {
                //     console.log("created");
                //     const Toast = this.$swal.mixin({
                //         toast: true,
                //         position: 'bottom-end',
                //         showConfirmButton: false,
                //         timer: 3000,
                //         timerProgressBar: true,
                //         didOpen: (toast) => {
                //             toast.addEventListener('mouseenter', this.$swal.stopTimer)
                //             toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                //         }
                //     })
                //
                //     Toast.fire({
                //         icon: this.status.flag,
                //         title: trans(this.status.msg)
                //     })
                // }
            });
        },
        compare( a, b ) {
           if (a.last_nom < b.last_nom) {
               return -1;
           }
           if (a.last_nom > b.last_nom) {
               return 1;
           }
           return 0;
        },
        handleSort(field){
            this.params.field = field;
            this.params.direction = this.params.direction == 'asc' ? "desc" : "asc";

        }

    },
}
</script>

<style scoped>

</style>
