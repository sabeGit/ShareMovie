<template>
    <div class="alert" :class="outerClass">
        {{ $store.state.noticeMessage.text }}
    </div>
</template>
<script>
export default {
    computed: {
        mode: function() {
            return this.$store.state.noticeMessage.mode;
        },
        visible: function() {
            return this.$store.state.noticeMessage.visible;
        },
        outerClass () {
            return {
                success: this.mode === "done",
                danger: this.mode === "error",
                // hidden_bottomside: !this.visible && !this.isTopside,
                // hidden_topside: !this.visible && this.isTopside,
                // show_bottomside: this.visible && !this.isTopside,
                // show_topside: this.visible && this.isTopside,
                // topside: this.isTopside
            }
        },
    }
}
</script>
