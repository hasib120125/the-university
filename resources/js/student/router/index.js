import VueRouter from 'vue-router';
import routes from './routes';
import middlewarePipeline from "../middlewares/middlewarePipeline";
import store from '../store';

const router = new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior (to, from, savedPosition) {
        let notScrolls = [
            'subject_overview',
            'subject_notes',
            'subject_notices',
            'lecture_notice_view',
            'subject_plan',
            'subject_materials',
            'subject_material_view',
            'subject_assignments',
            'subject_assignment_view',
            'lecture_assignment_view',
            'subject_exams',
            'subject_exam_attend',
            'subject_exam_list',
            'qa_list',
            'qa_reply',
            'ask_question',
        ];

        if (!notScrolls.includes(to.name))
            return { x: 0, y: 0, behavior: 'smooth' }
    }
})

router.beforeEach((to, from, next) => {
    const user = JSON.parse(localStorage.getItem('user'));

    if (user) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
    }

    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware

    const context = {
        to,
        from,
        next,
        store
    }

    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    })
});

export default router;
