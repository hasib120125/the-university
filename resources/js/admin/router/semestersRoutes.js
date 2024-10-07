import auth from "../middlewares/auth";
export const semestersRoutes = [
    {
        path: 'semesters',
        component: () => import(/* webpackChunkName: "admin/semester" */ './../pages/semester/Index'),
        name: "semesters",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'semesters/add',
        component: () => import(/* webpackChunkName: "admin/semester" */ './../pages/semester/Form'),
        name: "semester_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'semesters/edit/:id',
        component: () => import(/* webpackChunkName: "admin/semester" */ './../pages/semester/Form'),
        name: "semester_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
