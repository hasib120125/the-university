import auth from "../middlewares/auth";
export const gradeSystemRoutes = [
    {
        path: 'grade-system',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/grade_system/Index'),
        name: "grade_system",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'grade-system/add',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/grade_system/Form'),
        name: "grade_system_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'grade-system/edit/:id',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/grade_system/Form'),
        name: "grade_system_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
