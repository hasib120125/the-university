export const otherRoutes = [
    {
        path: '*',
        component: () => import(/* webpackChunkName: "admin/others" */ './../pages/404'),
        name: "not_found",
    }
];
