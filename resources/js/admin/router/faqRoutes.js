import auth from "../middlewares/auth";
export const faqRoutes = [
    {
        path: 'faqs',
        component: () => import(/* webpackChunkName: "admin/faq" */ './../pages/faq/Index'),
        name: "faqs",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'faqs/add',
        component: () => import(/* webpackChunkName: "admin/faq" */ './../pages/faq/Form'),
        name: "faqs_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'faqs/edit/:id',
        component: () => import(/* webpackChunkName: "admin/faq" */ './../pages/faq/Form'),
        name: "faqs_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
