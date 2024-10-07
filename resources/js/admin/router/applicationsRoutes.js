import auth from "../middlewares/auth";
export const applicationsRoutes = [
    {
        path: 'pending-applications',
        component: () => import(/* webpackChunkName: "admin/application" */ './../pages/application/pendingApplication'),
        name: "pending_applications",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
