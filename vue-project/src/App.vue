<template>
    <div>
        <Navbar></Navbar>
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from './components/UI/Navbar.vue';

export default {
    components: {
        Navbar,
    },

    mounted() {
        this.$axios.get('/api/auth/check').then(res => {
            if (res.status === 200) {
                localStorage.setItem('auth', 'true');
            } else {
                localStorage.setItem('auth', 'false');
            }
        });
    },
}
</script>

<style>

</style>