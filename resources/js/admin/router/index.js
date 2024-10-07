import VueRouter from 'vue-router';
import routes from './routes';
import middlewarePipeline from "../middlewares/middlewarePipeline";
import store from '../store';

const router = new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior (to, from, savedPosition) {
      return { x: 0, y: 0, behavior: 'smooth' }
    }
})

router.beforeEach((to, from, next) => {
    const user = JSON.parse(localStorage.getItem('user'));

    if (user) {
        axios.defaults.headers.common['Authorization'] = `Bearer `+user.token;
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
