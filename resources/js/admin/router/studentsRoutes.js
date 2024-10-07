import auth from "../middlewares/auth";
export const studentsRoutes = [
    {
        path: 'students',
        component: () => import(/* webpackChunkName: "admin/student" */ './../pages/student/Index'),
        name: "students",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'students/add',
        component: () => import(/* webpackChunkName: "admin/student" */ './../pages/student/Form'),
        name: "students_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'students/edit/:id',
        component: () => import(/* webpackChunkName: "admin/student" */ './../pages/student/Form'),
        name: "students_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'students/details/:id',
        component: () => import(/* webpackChunkName: "admin/student" */ './../pages/student/Details'),
        name: "student_details",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'in-active-students',
        component: () => import(/* webpackChunkName: "admin/student" */ './../pages/student/Inactive'),
        name: "in_active_students",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'all-students',
        component: () => import(/* webpackChunkName: "admin/student" */ './../pages/student/AllStudents'),
        name: "all_students",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'student-result/:student_id',
        component: () => import(/* webpackChunkName: "admin/student" */ './../pages/student/Result'),
        name: "student_result",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
