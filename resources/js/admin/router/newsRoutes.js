import auth from "../middlewares/auth";
export const newsRoutes = [
    {
        path: 'news',
        component: () => import(/* webpackChunkName: "admin/news" */ './../pages/news/Index'),
        name: "news",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'news/add',
        component: () => import(/* webpackChunkName: "admin/news" */ './../pages/news/Form'),
        name: "news_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'news/edit/:id',
        component: () => import(/* webpackChunkName: "admin/news" */ './../pages/news/Form'),
        name: "news_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
