<template>
    <div>
        <header>
            <Navbar />
        </header>
        <main>
            <div class="container">
                <NoticeMessage />
                <RouterView />
            </div>
        </main>
    </div>
</template>
<script>
import Navbar from './components/layouts/Navbar.vue'
import NoticeMessage from './components/layouts/NoticeMessage.vue'
import { INTERNAL_SERVER_ERROR } from './util';

export default {
    components: {
        Navbar,
        NoticeMessage
    },
    computed: {
        errorCode () {
            return this.$store.state.error.code;
        }
    },
    watch: {
        errorCode: {
            async handler (val) {
                if (val === INTERNAL_SERVER_ERROR) {
                    this.$router.push('/500')
                }
            },
            immediate: true
        }
    }
}
</script>
