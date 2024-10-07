import auth from "../middlewares/auth";
export const paymentRoutes = [
    {
        path: 'payments',
        component: () => import(/* webpackChunkName: "student/lecture" */ './../pages/payment/Index'),
        name: "payments",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'payments/add',
        component: () => import(/* webpackChunkName: "student/lecture" */ './../pages/payment/Add'),
        name: "add_payments",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
