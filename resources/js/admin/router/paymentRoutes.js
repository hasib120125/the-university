import auth from "../middlewares/auth";
export const paymentRoutes = [
    {
        path: 'payments/pending',
        component: () => import(/* webpackChunkName: "admin/payment" */ './../pages/payments/PendingList'),
        name: "payments_pending",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'payments/approved',
        component: () => import(/* webpackChunkName: "admin/payment" */ './../pages/payments/ApprovedList'),
        name: "payments_approved",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
