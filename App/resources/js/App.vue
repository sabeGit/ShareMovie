<template>
    <div>
        <header>
            <Navbar />
        </header>
        <main>
            <div class="container">
                <flash-message />
                <RouterView />
            </div>
        </main>
    </div>
</template>
<script>
import Navbar from './components/layouts/Navbar.vue'
import { INTERNAL_SERVER_ERROR, UNAUTHORIZED } from './util';

export default {
    components: {
        Navbar,
    },
    computed: {
        errorCode () {
            return this.$store.state.error.code;
        },
        beforeAuthPagePath () {
            return this.$store.getters['auth/beforeAuthPagePath'];
        }
    },
    watch: {
        errorCode: {
            async handler (val) {
                if (val === INTERNAL_SERVER_ERROR) {
                    this.$router.push('/500');
                } else if (val === UNAUTHORIZED) {
                    this.$router.push({ name: 'Login', query: { redirect: this.beforeAuthPagePath }});
                }
            },
            immediate: true
        },
        $route () {
            this.$store.commit('error/setCode', null);
        }
    }
}
</script>
