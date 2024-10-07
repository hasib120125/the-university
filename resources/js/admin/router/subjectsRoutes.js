import auth from "../middlewares/auth";
export const subjectsRoutes = [
    {
        path: 'subjects',
        component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/Index'),
        name: "subjects",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'subjects/add',
        component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/Form'),
        name: "subject_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'subjects/edit/:id',
        component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/Form'),
        name: "subject_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'subjects/details/:id',
        component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/Details'),
        children: [
            {
                path: '',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/SubjectOverview'),
                name: "subject_overview",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'lectures/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/lecture/Index'),
                name: "subject_lectures",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'lectures/:semester_id/add/',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/lecture/Form'),
                name: "lectures_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'lectures/:semester_id/edit/:lecture_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/lecture/Form'),
                name: "lectures_edit",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/notice/Index'),
                name: "subject_notices",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices/add/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/notice/Form'),
                name: "subject_notice_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices/details/:notice_id/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/notice/Details'),
                name: "subject_notice_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices/edit/:notice_id/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/notice/Form'),
                name: "subject_notice_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'subject-plan/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/subject_plan/Index'),
                name: "subject_plan",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'subject-plan/:semester_id/edit',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/subject_plan/Form'),
                name: "subject_plan_edit",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/material/Index'),
                name: "subject_materials",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials/add/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/material/Form'),
                name: "subject_material_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials/details/:material_id/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/material/Details'),
                name: "subject_material_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials/edit/:material_id/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/material/Form'),
                name: "subject_material_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/assignment/Index'),
                name: "subject_assignments",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/add/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/assignment/Form'),
                name: "subject_assignment_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/details/:assignment_id/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/assignment/Details'),
                name: "subject_assignment_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/edit/:assignment_id/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/assignment/Form'),
                name: "subject_assignment_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/:assignment_id/submitted-list/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/assignment/List'),
                name: "subject_assignment_submitted",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/exam/Index'),
                name: "subject_exams",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/add/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/exam/Form'),
                name: "subject_exam_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/edit/:exam_id/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/exam/Form'),
                name: "subject_exam_update",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/:exam_id/students/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/exam/student/Index'),
                name: "subject_exam_students",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/:exam_id/evaluate/:student_id/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/exam/student/Details'),
                name: "subject_exam_evaluate",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'students/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/student/Index'),
                name: "subject_students",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'students/grade-input/:semester_id',
                component: () => import(/* webpackChunkName: "admin/subject" */ './../pages/subject/details_components/student/GradeInput'),
                name: "subject_grade_students",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
        ]
    },
];
