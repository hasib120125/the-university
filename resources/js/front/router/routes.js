import NotFound from './../pages/404';
import Home from './../pages/Home';
import Login from './../pages/auth/Login';
import Faq from './../pages/page/Faq';
import Contact from './../pages/page/Contact';
import CustomPage from './../pages/page/CustomPage';
import StaticPage from './../pages/page/StaticPage';
import News from './../pages/page/news/Index';
import SingleNews from './../pages/page/news/Single';
import StudentRegistration from './../pages/page/StudentRegistration';
import Album from './../pages/gallery/Album';
import AlbumDetails from '../pages/gallery/AlbumDetails';

let routes = [
    {
        path: '/',
        component: Home,
        name: "home",
    },
    {
        path: '/login',
        component: Login,
        name: "login",
    },

    {
        path: '/faq',
        component: Faq,
        name: "faq",
    },

    {
        path: '/contact-us',
        component: Contact,
        name: "contact_us",
    },
    // {
    //     path: '/news',
    //     component: News,
    //     name: "news",
    // },
    // {
    //     path: '/news/:slug',
    //     component: SingleNews,
    //     name: "single_news",
    // },
    {
        path:'/student-registration',
        component: StudentRegistration,
        name: 'student_registration',
    },
    // {
    //     path: '/gallery',
    //     component: Album,
    //     name: "gallery",
    // },
    // {
    //     path: '/gallery/:id',
    //     component: AlbumDetails,
    //     name: "gallery_details",
    // },
    {
        path: '/:slug',
        component: StaticPage,
        name: "static_page",
    },

    {
        path: '/:menu',
        component: CustomPage,
        name: "main_menu_page",
    },
    {
        path: '/:menu/:submenu/:slug?',
        component: CustomPage,
        name: "sub_menu_page",
    },

    // 404 Routes
    {
        path: '*',
        component: NotFound,
        name: "not_found",
    }
]



export default routes;
