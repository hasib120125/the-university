import auth from "../middlewares/auth";
export const facultiesRoutes = [
    {
        path: 'faculties',
        component: () => import(/* webpackChunkName: "admin/faculty" */ './../pages/faculty/Index'),
        name: "faculties",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'faculties/add',
        component: () => import(/* webpackChunkName: "admin/faculty" */ './../pages/faculty/Form'),
        name: "faculty_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'faculties/edit/:id',
        component: () => import(/* webpackChunkName: "admin/faculty" */ './../pages/faculty/Form'),
        name: "faculty_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
