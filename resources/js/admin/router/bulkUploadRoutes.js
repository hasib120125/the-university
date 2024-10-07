import auth from "../middlewares/auth";
export const bulkUploadRoutes = [
    {
        path: 'bulk-video/upload',
        component: () => import(/* webpackChunkName: "admin/bulk/upload/video" */ './../pages/bulk_video_upload/Index'),
        name: "bulk_video_upload",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'bulk/video',
        component: () => import(/* webpackChunkName: "admin/bulk/video" */ './../pages/bulk_video_upload/List'),
        name: "bulk_video_list",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'bulk-audio/upload',
        component: () => import(/* webpackChunkName: "admin/bulk/upload/audio" */ './../pages/bulk_audio_upload/Index'),
        name: "bulk_audio_upload",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'bulk/audio',
        component: () => import(/* webpackChunkName: "admin/bulk/audio" */ './../pages/bulk_audio_upload/List'),
        name: "bulk_audio_list",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'bulk-subtitle/upload',
        component: () => import(/* webpackChunkName: "admin/bulk/upload/subtitle" */ './../pages/bulk_subtitle_upload/Index'),
        name: "bulk_subtitle_upload",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'bulk/subtitle',
        component: () => import(/* webpackChunkName: "admin/bulk/subtitle" */ './../pages/bulk_subtitle_upload/List'),
        name: "bulk_subtitle_list",
        meta: {
            middleware: [
                auth
            ]
        }
    }
];
