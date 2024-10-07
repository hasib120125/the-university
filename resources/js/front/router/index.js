import VueRouter from 'vue-router';
import routes from './routes';

const router = new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior (to, from, savedPosition) {
      return { x: 0, y: 0, behavior: 'smooth' }
    }
})

export default router;
