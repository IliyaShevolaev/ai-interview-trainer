<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-4">
            <router-link to="/" class="navbar-brand">AI Interview Trainer</router-link>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">Главная</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/interview/create" class="nav-link">Создать</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/find" class="nav-link">Поиск</router-link>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown" @click="toggleDropdown">
                        <button class="btn profile-btn" type="button">
                            <BootstrapIcon name="profile" size="20" />
                        </button>
                        <ul v-if="isDropdownOpen" class="dropdown-menu dropdown-menu-end show">
                            <li>
                                <router-link class="dropdown-item" to="/profile" v-if="isAuth">Профиль</router-link>
                                <router-link class="dropdown-item" to="/auth" v-else>Войти</router-link>
                            </li>
                            <li>
                                <router-link class="dropdown-item" to="/profile/rates">Мои результаты</router-link>
                            </li>
                            <li>
                                <router-link class="dropdown-item" to="/profile/interview-manage">Мои собеседования</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import BootstrapIcon from '@/components/UI/BootstrapIcon.vue';

export default {
    components: {
        BootstrapIcon
    },

    data() {
        return {
            isDropdownOpen: false
        };
    },

    computed: {
        isAuth() {
            return localStorage.getItem('auth') === 'true';
        }
    },

    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
    }
};
</script>

<style scoped>
.profile-btn {
    background-color: transparent;
    border: 1px solid var(--color-border);
    color: var(--color-text-2);
    border-radius: var(--radius-md);
    padding: 6px 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.profile-btn:hover {
    border-color: var(--color-border-strong);
    color: var(--color-text);
}

.dropdown-menu.show {
    display: block;
    position: absolute;
    right: 0;
    margin-top: var(--space-2);
}
</style>
