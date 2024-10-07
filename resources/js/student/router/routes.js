import Dashboard from './../pages/Dashboard';
import ProfileIndex from './../pages/profile/Index';
import ApplyNewSubjectIndex from './../pages/apply_new_subject/Index';
import App from './../layouts/App';
import auth from "../middlewares/auth";

import {paymentRoutes} from "./paymentRoutes";
import {subjectRoutes} from "./subjectRoutes";

const routes = [
    {
        path: '/student',
        component: App,
        children: [
            {
                path: '',
                component: Dashboard,
                name: "dashboard",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            //Profile
            {
                path: 'profile',
                component: ProfileIndex,
                name: "profile",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            //Apply New Lecture
            {
                path: 'apply-new-subject',
                component: ApplyNewSubjectIndex,
                name: "apply_new_subject",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'administration-notices/details/:notice_id',
                component: () => import(/* webpackChunkName: "student/Notice" */ './../pages/notice/Details'),
                name: "administration_notice_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'subject-notices/details/:notice_id',
                component: () => import(/* webpackChunkName: "student/Notice" */ './../pages/notice/SubjectNoticeDetails'),
                name: "subject_notice_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'result',
                component: () => import(/* webpackChunkName: "student/result" */ './../pages/result/Index'),
                name: "result",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'applications',
                component: () => import(/* webpackChunkName: "student/application" */ './../pages/application/Index'),
                name: "applications",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'applications/add',
                component: () => import(/* webpackChunkName: "student/application" */ './../pages/application/Form'),
                name: "applications_add",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
        ]
    },
]

//routes[0].children.push(...lecturesRoutes);
routes[0].children.push(...paymentRoutes);
routes[0].children.push(...subjectRoutes);

export default routes;
