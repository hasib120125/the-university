import auth from "../middlewares/auth";
export const departmentsRoutes = [
    {
        path: 'departments',
        component: () => import(/* webpackChunkName: "admin/department" */ './../pages/department/Index'),
        name: "departments",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'departments/add',
        component: () => import(/* webpackChunkName: "admin/department" */ './../pages/department/Form'),
        name: "department_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'departments/edit/:id',
        component: () => import(/* webpackChunkName: "admin/department" */ './../pages/department/Form'),
        name: "department_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
