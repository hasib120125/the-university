<template>
    <vue-editor v-model="content"
                :customModules="customModulesForEditor"
                useCustomImageHandler
                class="quill-editor"
                :editorOptions="editorSettings"
                @image-removed="handleImageRemoved"
                @image-added="imageAdded" @text-change="contentChange" />
</template>

<script>
import { VueEditor } from "vue2-editor";
import ImageResize from "quill-image-resize-vue";
import {ImageDrop} from "quill-image-drop-module";
import htmlEditButton from "quill-html-edit-button";

export default {
    props: ['model', 'deleteImages'],
    components:{ VueEditor },
    data() {
        return {
            content: null,
            delImages: [],
            customModulesForEditor: [
                { alias: "imageResize", module: ImageResize },
                { alias: "imageDrop", module: ImageDrop },
                { alias: "htmlEditButton", module: htmlEditButton },
            ],
            editorSettings: {
                modules: {
                    imageDrop: true,
                    imageResize: {},
                    htmlEditButton: {
                        debug: false,
                        syntax: true,
                        buttonHTML: '<i class="fas fa-code" style="color: rgba(63,63,63,.95); font-size: 17px"></i>'
                    }
                }
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
        imageAdded(file, Editor, cursorLocation, resetUploader) {
            let formData = new FormData();
            formData.append("image", file);

            axios.post('/api/admin/upload/image', formData)
                .then(response => {
                    let url = response.data; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                });
        },
        contentChange(delta, oldContents, source) {
            this.$emit('update:model', this.content);
        },
        handleImageRemoved(image) {
            this.delImages.push(image);
            this.$emit('update:deleteImages', this.delImages);
        }
    }
}
</script>

<style>
    .quill-editor {
        height: 500px;
        margin-bottom: 60px;
    }
</style>
