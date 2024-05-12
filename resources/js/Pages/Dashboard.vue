<template>
  <Layout :img-path="imgPath">
      <p>{{ $t('dashboard') }}</p>
      <div class="row">
          <div v-if="loading" class="d-flex justify-content-center align-items-center min-vh-100 fixed-top" style="background: #ffffffaa; transition: 1s">
              <pulse-loader :loading="loading" color="#6875f5" :size="size"></pulse-loader>
          </div>
          <div class="col-6">
              <div class="card border border-primary shadow shadow-sm">
                  <div class="card-header">
                     <div class="d-flex justify-content-between align-items-center">
                         <h5 class="mb-0 text-primary fw-bolder">
                             Issue Chart
                         </h5>
                         <div class="">
                             <Datepicker @update:modelValue="handleMonth" v-model="form.month" monthPicker />
                         </div>
                         <div class="">
                             <div class="btn-group">
                                 <button type="button" class="btn btn-light rounded-0" data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="fa-solid fa-ellipsis-vertical"></i>
                                 </button>
                                 <ul class="dropdown-menu dropdown-menu-end">
                                     <li><a :class="[chart1 === 'doughnut' ? 'active' : '']" class="dropdown-item" @click="changeChart1('doughnut')" href="#">Doughnut Chart</a></li>
                                     <li><a :class="[chart1 === 'barVertical' ? 'active' : '']" class="dropdown-item" @click="changeChart1('barVertical')">Bar Chart (vertical)</a></li>
                                     <li><a :class="[chart1 === 'barHorizontal' ? 'active' : '']" class="dropdown-item" @click="changeChart1('barHorizontal')" href="#">Bar Chart (horizontal)</a></li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                  </div>
                  <div class="card-body">
                      <Doughnut
                          class="animate__animated animate__fadeIn"
                          v-if="chart1 === 'doughnut' "
                          :chartData = "issueDoughnutChartData"
                          :chartOptions="issueDoughnutChartOptions"
                      />
                      <Bar
                          class="animate__animated animate__fadeIn"
                          v-if="chart1 === 'barVertical' "
                          :chartData="issueBarChartDataVertical"
                          :chartOptions="issueBarChartOptionsVertical"
                      />
                      <Bar
                          class="animate__animated animate__fadeIn"
                          v-if="chart1 === 'barHorizontal' "
                          :chartData="issueBarChartDataHorizontal"
                          :chartOptions="issueBarChartOptionsHorizontal"
                      />
                  </div>
              </div>
          </div>
          <div class="col-6">
              <div class="card border border-primary shadow shadow-sm">
                  <div class="card-header">
                      <div class="d-flex justify-content-between align-items-center">
                          <p class="mb-0">
                              Issue Chart
                          </p>
                          <div class="">
                              <Datepicker @update:modelValue="handleYear" v-model="form.year" yearPicker />
                          </div>
                          <div class="">
                              <i class="fa-solid fa-ellipsis-vertical"></i>
                          </div>
                      </div>
                  </div>
                  <div class="card-body">
                      <Bar
                          :chartData="productBarChartData"
                          :chartOptions="productBarChartOptions"
                      />
                  </div>
              </div>
          </div>
      </div>

  </Layout>
</template>

<script>
import Layout from "../Components/Layout.vue";
import Doughnut from "../Components/Doughnut.vue";
import Bar from "../Components/SideBar/Bar.vue";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

export default {
    name: "Dashboard",
    components: { Bar, Doughnut, Datepicker, PulseLoader },
    props: ["yearFromMonthObj", "monthFromMonthObj", 'imgPath', 'selectedYear', 'issueDoughnutChartLabel', 'issueDoughnutChartData', 'monthsPerYearIssueData'],
    layout : Layout,
    data() {
        return {
            chart1 : 'barHorizontal',
            loading: false,
            form: useForm({
                month: {
                    month: this.monthFromMonthObj,
                    year: this.yearFromMonthObj
                },
                year: this.selectedYear,
            }),

            productBarChartOptions :{
                responsive: true,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                indexAxis: 'y', //appear horizontal bar
                scales: {
                    yAxes: {
                        display: true
                    },
                    x: {
                        max: 100,
                        min: 0,
                        ticks: {
                            stepSize: 25
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
            productBarChartData : {
                labels: [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ],
                datasets: [{
                    axis: 'y',
                    data: this.monthsPerYearIssueData,
                    fill: false,
                    backgroundColor: ["#6366F1","#EF4444","#FBBF24","#10B981", "#EB4898"],
                    borderWidth: 1
                }]
            },

            issueBarChartOptionsVertical :{
                responsive: true,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                indexAxis: 'y', //appear horizontal bar
                scales: {
                    yAxes: {
                        display: true
                    },
                    x: {
                        max: 100,
                        min: 0,
                        ticks: {
                            stepSize: 25
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
            issueBarChartDataVertical : {
                labels: this.issueDoughnutChartLabel,
                datasets: [{
                    axis: 'y',
                    data: this.issueDoughnutChartData,
                    fill: false,
                    backgroundColor: ["#6366F1","#EF4444","#FBBF24","#10B981", "#EB4898"],
                    borderWidth: 1
                }]
            },

            issueBarChartOptionsHorizontal :{
                responsive: true,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                indexAxis: 'x', //appear horizontal bar
                scales: {
                    xAxes: {
                        display: true
                    },
                    y: {
                        max: 100,
                        min: 0,
                        ticks: {
                            stepSize: 25
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
            issueBarChartDataHorizontal : {
                labels: this.issueDoughnutChartLabel,
                datasets: [{
                    axis: 'x',
                    data: this.issueDoughnutChartData,
                    fill: false,
                    backgroundColor: ["#6366F1","#EF4444","#FBBF24","#10B981", "#EB4898"],
                    borderWidth: 1
                }]
            },

            issueDoughnutChartData: {
                labels: this.issueDoughnutChartLabel,
                datasets: [
                    {
                        backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
                        data: this.issueDoughnutChartData,
                        borderWidth: 2,
                        borderAlign: 'inner',
                        weight : 1

                    }

                ],
            },
            issueDoughnutChartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                cutout : 100,
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        align : 'center',
                        fullWidth: false,
                        labels: {
                            fontSize: 10,
                            color: '#000',
                            fontFamily: 'Montserrat',
                            usePointStyle: true,
                            boxWidth: 10,
                            padding: 30,
                        },


                    },
                    title: {
                        display: false,
                        text: 'Custom Chart Title'
                    }
                }

            },
        }
    },
    methods: {
        changeChart1($data) {
            return this.chart1 = $data;
        },
        handleYear(modelData) {
            this.form.year = modelData;
            Inertia.get(route('dashboard'),this.form,{
                replace: true,
                onBefore: () => {
                    this.loading = true;
                    console.log("hi");
                },
                onProgress: (progress) => {
                    console.log(progress.detail.progress.percentage)
                },
                onSuccess: () => {
                    this.loading = false;
                }
            });
        },
        handleMonth(modelData) {
            this.form.month = modelData;
            Inertia.get(route('dashboard'),this.form,{
                replace: true,
                onBefore: () => {
                    this.loading = true;
                    console.log("hi");
                },
                onProgress: (progress) => {
                    console.log(progress.detail.progress.percentage)
                },
                onSuccess: () => {
                    this.loading = false;
                }
            });
        }
    },
}
</script>

<style scoped>

</style>
