<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <p>name: {{ this.user.name }}</p>
                <p>email: {{ this.user.email }}</p>
                <button @click.prevent="logout" type="button" class="btn btn-danger">Log out</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            user: {
                name: null,
                email: null
            }
        }
    },

    mounted() {
        this.$axios.get('/api/user').then(res => {
            console.log(res);
            this.user.name = res.data.name;
            this.user.email = res.data.email;
        })
    },

    methods: {
        logout() {
            if (localStorage.getItem('auth') === 'true') {
                this.$axios.post('/api/auth/logout').then(() => {
                    localStorage.removeItem('auth');
                    this.$router.push({ name: 'auth' });
                });
            }
        },
    },
}
</script>
<style>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    flex-direction: column;
}
</style>