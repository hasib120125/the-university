import auth from "../middlewares/auth";
export const subjectRoutes = [
    {
        path: 'subjects',
        component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/Index'),
        name: "subjects",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'subjects/details/:id',
        component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/Details'),
        children: [
            {
                path: '',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/Overview'),
                name: "subject_overview",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notes',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/Notes'),
                name: "subject_notes",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'notices',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/Notices'),
                name: "subject_notices",
                props: true,
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'plan',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/Plan'),
                name: "subject_plan",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/Materials'),
                name: "subject_materials",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'materials/:material_id',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/MaterialDetails'),
                name: "subject_material_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/Assignments'),
                name: "subject_assignments",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'assignments/:assignment_id',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/AssignmentDetails'),
                name: "subject_assignment_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/Exams'),
                name: "subject_exams",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exams/attend/:exam_id',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/ExamAttend'),
                name: "subject_exam_attend",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'exam-list',
                component: () => import(/* webpackChunkName: "student/subject" */ './../pages/subject/details/ExamList'),
                name: "subject_exam_list",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
        ]
    },
];
