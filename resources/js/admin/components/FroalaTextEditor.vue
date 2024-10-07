<template>
    <froala
    :tag="'textarea'"
    :config="config"
    v-model="content" >
    </froala>
</template>

<script>
 // Import Froala Editor
import 'froala-editor/js/plugins.pkgd.min.js';
// import './froalaEditor';
// Import third party plugins
import 'froala-editor/js/third_party/embedly.min';
import 'froala-editor/js/third_party/font_awesome.min';

// Import Froala Editor css files.
// import 'froala-editor/css/froala_editor.pkgd.min.css';
import './froalaEditor.css'

export default {
    props: ['model', 'deleteImages'],
    data() {
        return {
            content: null,
            delImages: [],
            config: {
                key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==",
                attribution: false, // to hide "Powered by Froala"
                imageUploadParam: 'image',
                imageUploadMethod: 'post',
                imageUploadURL: "/api/admin/upload/image",
                requestHeaders: {
                    "Authorization": `Bearer `+ JSON.parse(localStorage.getItem('user')).token,
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                imageUploadParams: {
                    froala: 'true',
                    _token: document.head.querySelector("[name=csrf-token]").content
                },
                toolbarButtons: ['paragraphFormat', 'bold', 'italic', 'underline','align' ,'strikeThrough', 'outdent', 'indent', 'clearFormatting',
                                    'textColor','insertLink', 'insertTable','insertImage', 'insertVideo','html','|','undo', 'redo' ,
                                    ],
                imageEditButtons: ['imageDisplay','imageAlign', 'imageRemove','imageSize',
                '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove',
                ],
                tableStyles: {
                    custom_table: 'Custom Table',
                    table_bordered: 'Table Bordered'
                },
                quickInsertTags: [''],
                heightMax: 250,
                heightMin: 200,
                charCounterCount: false,
                videoUploadParam: 'video',
                videoUploadURL: '/api/admin/upload/video',
                videoUploadParams: {
                    froala: 'true',
                    _token: document.head.querySelector("[name=csrf-token]").content
                },
                videoUploadMethod: 'POST',
                videoMaxSize: 3*1024 * 1024 * 1024,
                videoAllowedTypes: ['webm', 'jpg', 'ogg', 'mp4'],
                events: {
                    'contentChanged': ()=> {
                        this.$emit('update:model', this.content);
                    },
                    'video.beforeUpload': function (videos) {
                        // Return false if you want to stop the video upload.
                    },
                    'video.uploaded': function (response) {
                        // Video was uploaded to the server.
                    },
                    'video.inserted': function ($img, response) {
                        // Video was inserted in the editor.
                    },
                    'video.replaced': function ($img, response) {
                        // Video was replaced in the editor.
                    },
                    'video.error': function (error, response) {
                        // Bad link.
                        if (error.code == 1) {

                        }

                        // No link in upload response.
                        else if (error.code == 2) {

                        }

                        // Error during video upload.
                        else if (error.code == 3) {

                        }

                        // Parsing response failed.
                        else if (error.code == 4) {

                        }

                        // Video too text-large.
                        else if (error.code == 5) {

                        }

                        // Invalid video type.
                        else if (error.code == 6) {

                        }

                        // Video can be uploaded only to same domain in IE 8 and IE 9.
                        else if (error.code == 7) {

                        }

                        // Response contains the original server response to the request if available.
                    }
                },
            },
        }
    },
    watch: {
        model() {
            this.content = this.model;
        },
        deleteImages() {
            this.delImages = this.deleteImages;
        }
    },
    methods: {

    }
}
</script>
