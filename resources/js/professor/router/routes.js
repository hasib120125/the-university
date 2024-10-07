import Dashboard from './../pages/Dashboard';
import App from './../layouts/App';

import { subjectsRoutes } from "./subjectsRoutes";
import { profileRoutes } from "./profileRoutes";
import {othersRoutes} from "./othersRoutes";

import LectureTable from './../pages/lecture_table/Index';
import GradeInputIndex from './../pages/grade/Index';
import auth from "../middlewares/auth";

let routes = [
    {
        path: '/professor',
        component: App,
        children: [
            {
                path: '',
                component: Dashboard,
                name: "home",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'lecture-schedule',
                component: LectureTable,
                name: 'lecture_schedule',
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'grade-input',
                component: GradeInputIndex,
                name: "grade_input",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
            {
                path: 'administration-notices/details/:notice_id',
                component: () => import(/* webpackChunkName: "professor/Notice" */ './../pages/notice/Details'),
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
                name: "dash_subject_notice_view",
                meta: {
                    middleware: [
                        auth
                    ]
                }
            },
        ]
    }
]

routes[0].children.push(...profileRoutes);
routes[0].children.push(...subjectsRoutes);
routes[0].children.push(...othersRoutes);

export default routes;

