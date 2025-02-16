<template>
    <div class="auth-page">
        <div class="container">
            <div class="registration-box">
                <div v-if="!isLoginMode">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input v-model="userData.name" type="text" class="form-control" placeholder="Enter username">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input v-model="userData.email" type="email" class="form-control" placeholder="name@example.com">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input v-model="userData.password" type="password" class="form-control"
                        placeholder="Enter password">
                </div>

                <div v-if="!isLoginMode" class="mb-1">
                    <label class="form-label">Confirm password</label>
                    <input v-model="userData.password_confirmation" type="password" class="form-control"
                        placeholder="Confirm your password">
                </div>

                <button @click="toggleMode" type="button" class="btn btn-link text-white w-100 mb-1">{{ isLoginMode ? 'Create an account' : 'Already have an account?' }}</button>

                <button @click.prevent="auth" type="button" class="btn btn-outline-light w-100">{{ isLoginMode ? 'Login' : 'Register' }}</button>

                <button @click.prevent="testUser" type="button" class="btn btn-outline-danger mt-2 w-100">Test user</button>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isLoginMode: false,
            userData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
        };
    },

    methods: {
        toggleMode() {
            this.isLoginMode = !this.isLoginMode;
        },
        auth() {
            this.$axios.get('/sanctum/csrf-cookie').then(() => {
                const endpoint = this.isLoginMode ? '/api/auth/login' : '/api/auth/register';
                const data = this.isLoginMode ? { email: this.userData.email, password: this.userData.password } : this.userData;

                this.$axios.post(endpoint, data).then(res => {
                    if (res.status == 200) {
                        localStorage.setItem('auth', 'true');
                        this.$router.push({name: 'profile'});
                    }
                });
            });
        },

        testUser() {
            this.userData.email = 'mail@mail.com';
            this.userData.password = '111';
        },
    },
};
</script>

<style scoped>
.auth-page {
    background-color: #121212 !important;
    color: #ffffff;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.registration-box {
    background-color: #1e1e1e;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    width: 300px;
}

.form-label {
    color: #ffffff;
}

.form-control {
    background-color: #333;
    color: #fff;
    border: 1px solid #555;
}

.form-control::placeholder {
    color: #bbb;
}
</style>
