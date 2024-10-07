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
                events: {
                    initialized: function () {
                        
                    }
                },
                toolbarButtons: ['paragraphFormat', 'bold', 'italic', 'underline','align' ,'strikeThrough', 'outdent', 'indent', 'clearFormatting',
                                    'textColor','insertLink', 'insertTable','insertImage','html','|','undo', 'redo' ,
                                    ],
                imageEditButtons: ['imageDisplay','imageAlign', 'imageRemove','imageSize',
                '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove',
                ],
                tableStyles: {
                    custom_table: 'Custom Table',
                    table_bordered: 'Table Bordered'
                },
                quickInsertTags: [''],
                events: {
                    // 'image.removed': ($img)=> {
                    //     this.delImages.push($img[0].currentSrc);
                    //     this.$emit('update:deleteImages', this.delImages);
                    // },
                    'contentChanged': ()=> {
                        this.$emit('update:model', this.content);
                    }
                },
                heightMax: 250,
                heightMin: 200,
                charCounterCount: false,
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
