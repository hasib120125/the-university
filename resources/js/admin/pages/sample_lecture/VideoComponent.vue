<template>
    <div :id="id"></div>
</template>

<script>
export default {
    props: {
        video: {
            type: String,
            required: true
        },
        id: {
            type: String,
            required: true
        }
    },
    mounted() {
        jwplayer(this.id).setup({
            file: this.video,
            controls: true,
            autostart: false,
            height: 360,
            repeat: false,
        });
    }
}
</script>
