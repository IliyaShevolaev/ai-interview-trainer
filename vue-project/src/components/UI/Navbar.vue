<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav ml-auto profile-nav">
                <li class="nav-item dropdown" @click="toggleDropdown">
                    <button class="btn btn-secondary dropdown-toggle"><BootstrapIcon name="profile" size="24" /></button>
                    <ul v-if="isDropdownOpen" class="dropdown-menu">
                        <li>
                            <router-link class="dropdown-item" to="/profile" v-if="isAuth">Профиль</router-link>
                            <router-link class="dropdown-item" to="/auth" v-else>Auth</router-link>
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
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link to="/" class="nav-link" active-class="active">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/interview/create" class="nav-link" active-class="active">Создать</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/find" class="nav-link" active-class="active">Поиск</router-link>
                </li>
            </ul>
            
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
.dropdown-menu {
    display: block;
    position: absolute;
    background-color: #1f1f1f;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.dropdown-item {
    padding: 10px 15px;
    display: block;
    color: white;
    text-decoration: none;
}
</style>