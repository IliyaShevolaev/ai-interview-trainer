<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card" style="max-width: 420px;">
                <h4 class="mb-4 text-center">{{ isLoginMode ? 'Вход в аккаунт' : 'Создание аккаунта' }}</h4>

                <div class="mode-switch mb-4">
                    <button type="button" class="mode-tab" :class="{ active: isLoginMode }" @click="isLoginMode = true">
                        Войти
                    </button>
                    <button type="button" class="mode-tab" :class="{ active: !isLoginMode }" @click="isLoginMode = false">
                        Зарегистрироваться
                    </button>
                </div>

                <div v-if="!isLoginMode" class="mb-3">
                    <label class="form-label">Имя пользователя</label>
                    <input v-model="userData.name" type="text" class="form-control" placeholder="Введите имя">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input v-model="userData.email" type="email" class="form-control" placeholder="name@example.com">
                </div>

                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input v-model="userData.password" type="password" class="form-control" placeholder="Введите пароль">
                </div>

                <div v-if="!isLoginMode" class="mb-4">
                    <label class="form-label">Подтверждение пароля</label>
                    <input v-model="userData.password_confirmation" type="password" class="form-control"
                        placeholder="Повторите пароль">
                </div>

                <button @click.prevent="auth" type="button" class="btn btn-accent w-100 mb-2">
                    {{ isLoginMode ? 'Войти' : 'Зарегистрироваться' }}
                </button>

                <button @click.prevent="testUser" type="button" class="btn btn-ghost w-100">
                    Тестовый пользователь
                </button>
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
        auth() {
            this.$axios.get('/sanctum/csrf-cookie').then(() => {
                const endpoint = this.isLoginMode ? '/api/auth/login' : '/api/auth/register';
                const data = this.isLoginMode ? { email: this.userData.email, password: this.userData.password } : this.userData;

                this.$axios.post(endpoint, data).then(res => {
                    if (res.status == 200 || res.status == 201) {
                        console.log(res);
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
.mode-switch {
    display: flex;
    gap: var(--space-2);
    padding: var(--space-1);
    background-color: var(--color-surface-2);
    border-radius: var(--radius-md);
}

.mode-tab {
    flex: 1;
    padding: var(--space-2) var(--space-4);
    background-color: transparent;
    color: var(--color-text-2);
    border: none;
    border-radius: var(--radius-sm);
    font-size: 0.9rem;
    font-weight: 500;
}

.mode-tab.active {
    background-color: var(--color-accent);
    color: #fff;
}

.mode-tab:not(.active):hover {
    color: var(--color-text);
}
</style>
