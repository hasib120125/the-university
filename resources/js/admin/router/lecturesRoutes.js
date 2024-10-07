import auth from "../middlewares/auth";
export const lecturesRoutes = [
    {
        path: 'lectures',
        component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/Index'),
        name: "lectures",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'lectures/add',
        component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/Form'),
        name: "lectures_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'lectures/edit/:id',
        component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/Form'),
        name: "lectures_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'lectures/details/:id',
        component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/Details'),
        children: [
            {
                path: '',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/LectureOverview'),
                name: "lecture_overview",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/notice/Index'),
                name: "lecture_notices",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices/add',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/notice/Form'),
                name: "lecture_notice_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices/details/:notice_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/notice/Details'),
                name: "lecture_notice_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices/edit/:notice_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/notice/Form'),
                name: "lecture_notice_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'lecture-plan',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/lecture_plan/Index'),
                name: "lecture_plan",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'lecture-plan/edit',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/lecture_plan/Form'),
                name: "lecture_plan_edit",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },//managements
            {
                path: 'managements',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/management/Index'),
                name: "lecture_managements",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'managements/add',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/management/Form'),
                name: "lecture_management_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'managements/details/:management_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/management/Details'),
                name: "lecture_management_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'managements/edit/:management_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/management/Form'),
                name: "lecture_management_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/material/Index'),
                name: "lecture_materials",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials/add',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/material/Form'),
                name: "lecture_material_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials/details/:material_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/material/Details'),
                name: "lecture_material_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials/edit/:material_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/material/Form'),
                name: "lecture_material_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/assignment/Index'),
                name: "lecture_assignments",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/add',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/assignment/Form'),
                name: "lecture_assignment_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/details/:assignment_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/assignment/Details'),
                name: "lecture_assignment_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/edit/:assignment_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/assignment/Form'),
                name: "lecture_assignment_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/submitted-list/:assignment_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/assignment/List'),
                name: "lecture_assignment_submitted",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/exam/Index'),
                name: "lecture_exams",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/add',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/exam/Form'),
                name: "lecture_exam_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/edit/:exam_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/exam/Form'),
                name: "lecture_exam_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/:exam_id/students',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/exam/student/Index'),
                name: "lecture_exam_students",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/:exam_id/evaluate/:student_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/exam/student/Details'),
                name: "lecture_exam_evaluate",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/:exam_id/questions',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/exam/question/Index.vue'),
                name: "lecture_exam_questions",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/:exam_id/questions/add',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/exam/question/Form'),
                name: "lecture_exam_question_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/:exam_id/questions/edit/:question_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/exam/question/Form'),
                name: "lecture_exam_question_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'majors',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/major/Index'),
                name: "lecture_majors",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'majors/add',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/major/Form'),
                name: "lecture_major_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'majors/edit/:major_id',
                component: () => import(/* webpackChunkName: "admin/lecture" */ './../pages/lecture/details_components/major/Form'),
                name: "lecture_major_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
        ]
    },
];
