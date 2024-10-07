<template>
    <div class="row">
        <div class="col_3 pr_5">
            <div class="inline_card">
                <span>
                    <i class='bx bx-user'></i>
                </span>
                <h2>{{ activeStudentsCount }}</h2>
                <p>{{ trans('admin.label.dashboard.total_active_students') }}</p>
                <svg class="ct-chart-line">
                    <g>
                        <g class="ct-series ct-series-a">
                            <path
                                d="M0,100L0,100C19.317,100,19.317,57.5,38.634,57.5C57.951,57.5,57.951,74.5,77.268,74.5C96.585,74.5,96.585,15,115.902,15C135.219,15,135.219,57.5,154.536,57.5C173.853,57.5,173.853,36.25,193.17,36.25C212.487,36.25,212.487,68.125,231.804,68.125C251.121,68.125,251.121,100,270.438,100L270.438,100Z"
                                class="ct-area"></path>
                            <path
                                d="M0,100C19.317,100,19.317,57.5,38.634,57.5C57.951,57.5,57.951,74.5,77.268,74.5C96.585,74.5,96.585,15,115.902,15C135.219,15,135.219,57.5,154.536,57.5C173.853,57.5,173.853,36.25,193.17,36.25C212.487,36.25,212.487,68.125,231.804,68.125C251.121,68.125,251.121,100,270.438,100"
                                class="ct-line"></path>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
        <div class="col_3 pr_5">
            <div class="inline_card">
                <span>
                    <i class='lni lni-users'></i>
                </span>
                <h2>{{ totalStudentsCount }}</h2>
                <p>{{ trans('admin.label.dashboard.total_students') }}</p>
                <svg class="ct-chart-line">
                    <g>
                        <g class="ct-series ct-series-a">
                            <path
                                d="M0,100L0,100C19.317,100,19.317,57.5,38.634,57.5C57.951,57.5,57.951,74.5,77.268,74.5C96.585,74.5,96.585,15,115.902,15C135.219,15,135.219,57.5,154.536,57.5C173.853,57.5,173.853,36.25,193.17,36.25C212.487,36.25,212.487,68.125,231.804,68.125C251.121,68.125,251.121,100,270.438,100L270.438,100Z"
                                class="ct-area"></path>
                            <path
                                d="M0,100C19.317,100,19.317,57.5,38.634,57.5C57.951,57.5,57.951,74.5,77.268,74.5C96.585,74.5,96.585,15,115.902,15C135.219,15,135.219,57.5,154.536,57.5C173.853,57.5,173.853,36.25,193.17,36.25C212.487,36.25,212.487,68.125,231.804,68.125C251.121,68.125,251.121,100,270.438,100"
                                class="ct-line"></path>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
        <div class="col_3 pr_5">
            <div class="inline_card">
                <span>
                    <i class="lni lni-crown"></i>
                </span>
                <h2>{{ subjectsCount }}</h2>
                <p>{{ trans('admin.label.dashboard.total_subjects') }}</p>
                <svg class="ct-chart-line">
                    <g>
                        <g class="ct-series ct-series-a">
                            <path
                                d="M0,100L0,100C19.317,100,19.317,57.5,38.634,57.5C57.951,57.5,57.951,74.5,77.268,74.5C96.585,74.5,96.585,15,115.902,15C135.219,15,135.219,57.5,154.536,57.5C173.853,57.5,173.853,36.25,193.17,36.25C212.487,36.25,212.487,68.125,231.804,68.125C251.121,68.125,251.121,100,270.438,100L270.438,100Z"
                                class="ct-area"></path>
                            <path
                                d="M0,100C19.317,100,19.317,57.5,38.634,57.5C57.951,57.5,57.951,74.5,77.268,74.5C96.585,74.5,96.585,15,115.902,15C135.219,15,135.219,57.5,154.536,57.5C173.853,57.5,173.853,36.25,193.17,36.25C212.487,36.25,212.487,68.125,231.804,68.125C251.121,68.125,251.121,100,270.438,100"
                                class="ct-line"></path>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
        <div class="col_3 ">
            <div class="inline_card">
                <span>
                    <i class="lni lni-crown"></i>
                </span>
                <h2>{{ departmentsCount }}</h2>
                <p>{{ trans('admin.label.dashboard.total_departments') }}</p>
                <svg class="ct-chart-line">
                    <g>
                        <g class="ct-series ct-series-a">
                            <path
                                d="M0,100L0,100C19.317,100,19.317,57.5,38.634,57.5C57.951,57.5,57.951,74.5,77.268,74.5C96.585,74.5,96.585,15,115.902,15C135.219,15,135.219,57.5,154.536,57.5C173.853,57.5,173.853,36.25,193.17,36.25C212.487,36.25,212.487,68.125,231.804,68.125C251.121,68.125,251.121,100,270.438,100L270.438,100Z"
                                class="ct-area"></path>
                            <path
                                d="M0,100C19.317,100,19.317,57.5,38.634,57.5C57.951,57.5,57.951,74.5,77.268,74.5C96.585,74.5,96.585,15,115.902,15C135.219,15,135.219,57.5,154.536,57.5C173.853,57.5,173.853,36.25,193.17,36.25C212.487,36.25,212.487,68.125,231.804,68.125C251.121,68.125,251.121,100,270.438,100"
                                class="ct-line"></path>
                        </g>
                    </g>
                </svg>
            </div>
        </div>

        <div class="col_3 pr_5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.label.dashboard.recent_view') }}</div>
                </div>
                <div class="card-body">
                    <canvas id="myChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col_3 pr_5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.label.dashboard.top_subject') }}</div>
                </div>
                <div class="card-body">
                    <canvas id="topSubjectBarChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col_3 pr_5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.label.dashboard.top_department') }}</div>
                </div>
                <div class="card-body">
                    <canvas id="topDepartmentPieChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col_3 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.label.dashboard.student_by_semester') }}</div>
                </div>
                <div class="card-body">
                    <canvas id="stLineChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col_8 pr_5">
            <div class="card">
                <div class="card-body">
                    <calendar />
                </div>
            </div>
        </div>

        <div class="col_4 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.label.dashboard.curent_user.curent_users') }}</div>
                </div>
                <div class="card-body">
                    <table class="table table_bordered">
                        <thead>
                            <tr>
                                <th>{{ trans('admin.label.dashboard.curent_user.name') }}</th>
                                <th>{{ trans('admin.label.dashboard.curent_user.id') }}</th>
                                <th>{{ trans('admin.label.dashboard.curent_user.watched_from') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <template v-if="currentUsers.length > 0">
                                <tr v-for="(user, index) in currentUsers" :key="'user_'+index">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.student_no }}</td>
                                    <td>{{ user.watched_from }}</td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="3">{{ trans('admin.label.dashboard.curent_user.no_user') }}</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col_4 pr_5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.label.dashboard.upcoming_lectures') }}</div>
                </div>
                <div class="card-body">
                    <table-component api-url="/api/admin/upcoming-lectures"
                                        :fields="lectureFields"
                                        :show-search="false"
                                        :show-paginate="false"
                                        ref="tableComponent"
                                        :sort-order="[]"
                                        >
                    </table-component>
                </div>
            </div>
        </div>

        <div class="col_4 pr_5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.label.dashboard.upcoming_exams') }}</div>
                </div>
                <div class="card-body">
                    <table-component api-url="/api/admin/upcoming-exams"
                                        :fields="examFields"
                                        :show-search="false"
                                        :show-paginate="false"
                                        ref="tableComponent"
                                        :sort-order="[]"
                                        >
                    </table-component>
                </div>
            </div>
        </div>
        <div class="col_4 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.label.dashboard.upcoming_semesters') }}</div>
                </div>
                <div class="card-body">
                    <table-component api-url="/api/admin/upcoming-semesters"
                                        :fields="semesterFields"
                                        :show-search="false"
                                        :show-paginate="false"
                                        ref="tableComponent"
                                        :sort-order="[]"
                                        >
                    </table-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';
import TableComponent from "./../components/TableComponent";
import Calendar from "./Calendar";

export default {
    components: {
        TableComponent,
        Calendar
    },
    data() {
        return {
            masks: {
                weekdays: 'WWW',
            },
            attributes: [
                {
                    key: 1,
                    customData: {
                        title: 'Lunch with mom.',
                        class: 'bg-red-600 text-white',
                    },
                    dates: new Date(2021, 8, 11),
                },
            ],
            viewChart: null,
            currentUsers: [],
            viewChartOptions: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                },
                elements: {
                    line: {
                        fill: false,
                        tension: .15
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            },
            stLineChart: null,
            stLineChartOptions: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                },
                elements: {
                    line: {
                        fill: false,
                        tension: .15
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            },
            topSubjectBarChart: null,
            topSubjectBarChartOptions: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                },
                elements: {
                    line: {
                        fill: false,
                        tension: .15
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            },
            topDepartmentPieChart: null,
            topDepartmentPieChartOptions: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                },
                elements: {
                    line: {
                        fill: false,
                        tension: .15
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            },
            activeStudentsCount: 0,
            totalStudentsCount: 0,
            subjectsCount: 0,
            departmentsCount: 0,
            lectureFields: [
                {
                    name: 'name',
                    title: this.trans('admin.form.lecture.name')
                },
                {
                    name: 'subject.name',
                    title: this.trans('admin.form.lecture.subject')
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    data: [
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            customLink: true,
                            params: {subject_id: 'subject_id', semester_id: 'semester_id', lecture_id: 'id'},
                            path: `${window.location.origin}/admin/subjects/details/subject_id/lectures/semester_id/edit/lecture_id`
                        }
                    ]
                }
            ],
            examFields: [
                {
                    name: 'title',
                    title: this.trans('admin.form.exam.title')
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: this.trans('common.index.students'),
                            route: 'subject_exam_students',
                            params: {exam_id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'subject_exam_update',
                            params: {exam_id: 'id', id: 'subject_id'}
                        }
                    ]
                }
            ],
            semesterFields: [
                {
                    name: 'year',
                    title: this.trans('admin.form.semester.year'),
                    sortField: 'year',
                    searchable: true
                },
                {
                    name: 'season_name',
                    title: this.trans('admin.form.semester.season'),
                    searchable: false
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'semester_edit',
                            params: {id: 'id'}
                        }
                    ]
                }
            ],
        }
    },
    created() {
        Echo.join('counter').here((users) => {
            this.currentUsers = users.filter(user => user.name !== 'Admin');
        }).joining((user) => {
            this.currentUsers.push(user)
        }).leaving((user) => {
            this.currentUsers = this.currentUsers.filter(u => u.id !== user.id)
        });

        axios.get('/api/admin/total-students-count').then((response) => {
            this.totalStudentsCount = response.data.data
        })

        axios.get('/api/admin/active-students-count').then((response) => {
            this.activeStudentsCount = response.data.data
        })

        axios.get('/api/admin/subjects-count').then((response) => {
            this.subjectsCount = response.data.data
        })

        axios.get('/api/admin/departments-count').then((response) => {
            this.departmentsCount = response.data.data
        })
    },
    mounted() {
        this.viewChart = new Chart(document.getElementById('myChart'), {
            type: 'line',
            data: {
                datasets: [{
                    label: '# of Views',
                    borderWidth: 2,
                    borderColor: '#36496a',
                    pointBackgroundColor: '#36496a',
                    pointRadius: 4,
                    pointHoverBackgroundColor: '#36496a'
                }]
            },
            options: this.viewChartOptions
        });
        this.getRecentViewData();

        this.stLineChart = new Chart(document.getElementById('stLineChart'), {
            type: 'line',
            data: {
                datasets: [{
                    label: '# of student by semester',
                    borderWidth: 2,
                    borderColor: '#36496a',
                    pointBackgroundColor: '#36496a',
                    pointRadius: 4,
                    pointHoverBackgroundColor: '#36496a'
                }]
            },
            options : this.stLineChartOptions
        });

        this.getStLineChartData()

        this.topSubjectBarChart = new Chart(document.getElementById('topSubjectBarChart'), {
            type: 'bar',
            data: {
                datasets: [{
                    borderWidth: 2,
                    borderColor: '#36496a',
                    backgroundColor: [
                            'rgb(54, 73, 106)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)',
                            'rgb(153, 102, 255)',
                            'rgb(32, 219, 213)',
                            'rgb(212, 69, 64)',
                            'rgb(231, 148, 57)',
                            'rgb(201, 203, 207)',
                            'rgb(54, 162, 235)',
                            'rgb(51, 51, 51)',
                        ],
                    pointBackgroundColor: '#36496a',
                    pointRadius: 4,
                    pointHoverBackgroundColor: '#36496a'
                }]
            },
            options: this.topSubjectBarChartOptions
        });

        this.getTopSubjectBarChartData()

        this.topDepartmentPieChart = new Chart(document.getElementById('topDepartmentPieChart'), {
            type: 'pie',
            data: {
                datasets: [{
                    borderWidth: 2,
                    borderColor: '#36496a',
                    backgroundColor: [
                            'rgb(54, 73, 106)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)',
                            'rgb(153, 102, 255)',
                            'rgb(32, 219, 213)',
                            'rgb(212, 69, 64)',
                            'rgb(231, 148, 57)',
                            'rgb(201, 203, 207)',
                            'rgb(54, 162, 235)',
                            'rgb(51, 51, 51)',
                        ],
                    pointBackgroundColor: '#36496a',
                    pointRadius: 4,
                    pointHoverBackgroundColor: '#36496a'
                }]
            },
            options: this.topDepartmentPieChartOptions
        });

        this.getTopDepartmentPieChartData()

    },
    computed: {

    },
    methods: {
        getRecentViewData() {
            axios.get('/api/admin/recent-view').then((response) => {
                this.viewChart.data.labels = response.data.labels;
                this.viewChart.data.datasets[0].data = response.data.data;
                this.viewChart.update();
            })
        },
        getStLineChartData() {
            axios.get('/api/admin/student-by-semester').then((response) => {
                this.stLineChart.data.labels = response.data.labels;
                this.stLineChart.data.datasets[0].data = response.data.data;
                this.stLineChart.update();
            })
        },
        getTopSubjectBarChartData() {
            axios.get('/api/admin/top-subjects').then((response) => {
                this.topSubjectBarChart.data.labels = response.data.labels;
                this.topSubjectBarChart.data.datasets[0].data = response.data.data;
                this.topSubjectBarChart.update();
            })
        },
        getTopDepartmentPieChartData() {
            axios.get('/api/admin/top-departments').then((response) => {
                this.topDepartmentPieChart.data.labels = response.data.labels;
                this.topDepartmentPieChart.data.datasets[0].data = response.data.data;
                this.topDepartmentPieChart.data.backgroundColor = response.data.backgroundColor;
                this.topDepartmentPieChart.update();
            })
        }
    }
}
</script>
