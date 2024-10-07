import Dashboard from './../pages/Dashboard';
import auth from "../middlewares/auth";

import StudentTFForm from './../pages/student-tuition-fees/Form';
import StudentTFIndex from './../pages/student-tuition-fees/Index';
import CurriculumFeeIndex from './../pages/curriculum-fees/Index';
import CurriculumFeeForm from './../pages/curriculum-fees/Form';
import OtherFeeIndex from './../pages/other-fees/Index';
import MenuIndex from './../pages/menu/Index';
import RegistrationOpenIndex from './../pages/registration-open/Index';
import RegistrationOpenForm from './../pages/registration-open/Form';
import GradeInputIndex from './../pages/grade/Index';
import SettingIndex from './../pages/setting/Index';
import SampleLectureIndex from './../pages/sample_lecture/Index';
import Profile from './../pages/profile/Form';
import FooterTop from './../pages/footer_top/Index';
import App from './../layouts/App';

import {facultiesRoutes} from "./facultiesRoutes";
import {pageRoutes} from "./pageRoutes";
import {departmentsRoutes} from "./departmentsRoutes";
import {subjectsRoutes} from "./subjectsRoutes";
import {semestersRoutes} from "./semestersRoutes";
import {studentsRoutes} from "./studentsRoutes";
import {professorsRoute} from "./professorsRoute";
import {noticesRoutes} from "./noticesRoutes";
import {lecturesRoutes} from "./lecturesRoutes";
import {slidersRoutes} from "./slidersRoutes";
import {featuresRoutes} from "./featuresRoutes";
import {faqRoutes} from "./faqRoutes";
import {socialRoutes} from "./socialRoutes";
import {bulkUploadRoutes} from "./bulkUploadRoutes";
import {newsRoutes} from "./newsRoutes";
import {staticPageRoutes} from "./staticPageRoutes";
import {paymentRoutes} from "./paymentRoutes";
import {otherRoutes} from "./otherRoutes.js";
import {galleryRoutes} from "./galleryRoutes.js";
import {fixedPageRoute} from "./fixedPageRoute.js";
import {popUpRoutes} from "./popUpRoutes.js";
import {gradeSystemRoutes} from "./gradeSystemRoutes.js";
import {applicationsRoutes} from "./applicationsRoutes.js";

let routes = [{
    path: '/admin',
    component: App,
    children: [{
        path: '',
        component: Dashboard,
        name: "dashboard",
        meta: {
            middleware: [
                auth
            ]
        }
    },
        // student-tuition-fees Routes
        {
            path: 'student-tuition-fees',
            component: StudentTFIndex,
            name: "tuition_fees",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'profile',
            component: Profile,
            name: "profile",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'student-tuition-fees/add',
            component: StudentTFForm,
            name: "tuition_fees_add",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'student-tuition-fees/edit/:id',
            component: StudentTFForm,
            name: "tuition_fees_edit",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        // curriculum-fees Routes
        {
            path: 'curriculum-fees',
            component: CurriculumFeeIndex,
            name: "curriculum_fees",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'curriculum-fees/add',
            component: CurriculumFeeForm,
            name: "curriculum_fees_add",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'curriculum-fees/edit/:id',
            component: CurriculumFeeForm,
            name: "curriculum_fees_edit",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'registration-open',
            component: RegistrationOpenIndex,
            name: "registration_open",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        // {
        //     path: 'registration-open/add',
        //     component: RegistrationOpenForm,
        //     name: "registration_open_add",
        //     meta: {
        //         middleware: [
        //             auth
        //         ]
        //     }
        // },
        {
            path: 'registration-open/edit/:id',
            component: RegistrationOpenForm,
            name: "registration_open_edit",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'menus',
            component: MenuIndex,
            name: "menus",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'other-fees',
            component: OtherFeeIndex,
            name: "other_fees",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'grade-input',
            component: GradeInputIndex,
            name: "grade_input",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'settings',
            component: SettingIndex,
            name: "settings",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'sample-lectures',
            component: SampleLectureIndex,
            name: "sample_lectures",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: 'footer-top',
            component: FooterTop,
            name: "footer_top",
            meta: {
                middleware: [
                    auth
                ]
            }
        },
    ]
},]
routes[0].children.push(...socialRoutes);
// routes[0].children.push(...facultiesRoutes);
routes[0].children.push(...galleryRoutes);
routes[0].children.push(...pageRoutes);
routes[0].children.push(...faqRoutes);
routes[0].children.push(...departmentsRoutes);
routes[0].children.push(...subjectsRoutes);
routes[0].children.push(...semestersRoutes);
routes[0].children.push(...studentsRoutes);
routes[0].children.push(...professorsRoute);
routes[0].children.push(...noticesRoutes);
// routes[0].children.push(...lecturesRoutes);
routes[0].children.push(...slidersRoutes);
routes[0].children.push(...featuresRoutes);
routes[0].children.push(...newsRoutes);
routes[0].children.push(...staticPageRoutes);
routes[0].children.push(...bulkUploadRoutes);
routes[0].children.push(...paymentRoutes);
routes[0].children.push(...fixedPageRoute);
routes[0].children.push(...popUpRoutes);
routes[0].children.push(...gradeSystemRoutes);
routes[0].children.push(...applicationsRoutes);
routes[0].children.push(...otherRoutes);


export default routes;
