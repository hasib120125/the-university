import NotFound from "../pages/404";

export const othersRoutes = [
    {
        path: '*',
        component:  () => import(/* webpackChunkName: "professor/others" */ './../pages/404'),
        name: 'not_found'
    },
];
