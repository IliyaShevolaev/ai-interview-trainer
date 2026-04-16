<template>
    <nav class="navbar">
        <div class="navbar-inner">
            <router-link to="/" class="brand">AI Interview Trainer</router-link>

            <ul class="nav-center">
                <li>
                    <router-link to="/" class="nav-link" exact-active-class="is-active">Главная</router-link>
                </li>
                <li>
                    <router-link to="/interview/create" class="nav-link" active-class="is-active">Создать</router-link>
                </li>
                <li>
                    <router-link to="/find" class="nav-link" active-class="is-active">Поиск</router-link>
                </li>
            </ul>

            <div class="user-menu" ref="menu">
                <router-link v-if="!isAuth" to="/auth" class="btn btn-ghost btn-sign">
                    Войти
                </router-link>

                <template v-else>
                    <button class="avatar-btn" @click="toggleDropdown" :class="{ open: isDropdownOpen }">
                        <span class="avatar-initial">{{ initial }}</span>
                    </button>

                    <div v-if="isDropdownOpen" class="menu-panel">
                        <div class="panel-header">
                            <div class="avatar-lg">{{ initial }}</div>
                            <div class="panel-user">
                                <div class="panel-name">{{ user.name || 'Пользователь' }}</div>
                                <div class="panel-email">{{ user.email }}</div>
                            </div>
                        </div>

                        <div class="panel-divider"></div>

                        <router-link to="/profile" class="menu-item" @click="close">Профиль</router-link>
                        <router-link to="/profile/rates" class="menu-item" @click="close">Мои результаты</router-link>
                        <router-link to="/profile/interview-manage" class="menu-item" @click="close">Мои собеседования</router-link>

                        <div class="panel-divider"></div>

                        <button class="menu-item menu-item-danger" @click="logout">Выйти</button>
                    </div>
                </template>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            isDropdownOpen: false,
            user: { name: '', email: '' },
        };
    },

    computed: {
        isAuth() {
            return localStorage.getItem('auth') === 'true';
        },
        initial() {
            const source = this.user.name || this.user.email || '?';
            return source.charAt(0).toUpperCase();
        },
    },

    mounted() {
        if (this.isAuth) {
            this.fetchUser();
        }
        document.addEventListener('click', this.handleOutsideClick);
    },

    beforeUnmount() {
        document.removeEventListener('click', this.handleOutsideClick);
    },

    methods: {
        fetchUser() {
            this.$axios.get('/api/user').then(res => {
                this.user.name = res.data.name;
                this.user.email = res.data.email;
            }).catch(() => {});
        },

        toggleDropdown(event) {
            event.stopPropagation();
            this.isDropdownOpen = !this.isDropdownOpen;
        },

        close() {
            this.isDropdownOpen = false;
        },

        handleOutsideClick(event) {
            if (this.$refs.menu && !this.$refs.menu.contains(event.target)) {
                this.isDropdownOpen = false;
            }
        },

        logout() {
            this.$axios.post('/api/auth/logout').then(() => {
                localStorage.removeItem('auth');
                this.isDropdownOpen = false;
                this.$router.push({ name: 'auth' });
            });
        },
    },
};
</script>

<style scoped>
.navbar {
    height: 64px;
    background-color: var(--color-surface);
    border-bottom: 1px solid var(--color-border);
    padding: 0;
}

.navbar-inner {
    height: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 var(--space-6);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-6);
}

.brand {
    font-weight: 600;
    color: var(--color-text);
    font-size: 0.95rem;
    text-decoration: none;
    letter-spacing: -0.01em;
}

.brand:hover {
    color: var(--color-text);
}

.nav-center {
    display: flex;
    gap: var(--space-1);
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-link {
    display: inline-block;
    color: var(--color-text-2);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-md);
    transition: color 0.15s, background-color 0.15s;
}

.nav-link:hover {
    color: var(--color-text);
    background-color: var(--color-surface-2);
}

.nav-link.is-active {
    color: var(--color-text);
    background-color: var(--color-surface-2);
}

.user-menu {
    position: relative;
}

.btn-sign {
    padding: 0.4rem 1rem;
    font-size: 0.9rem;
}

.avatar-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid var(--color-border);
    background-color: var(--color-surface-2);
    color: var(--color-text);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: border-color 0.15s, transform 0.15s;
}

.avatar-btn:hover {
    border-color: var(--color-accent);
}

.avatar-btn.open {
    border-color: var(--color-accent);
}

.avatar-initial {
    display: inline-block;
    line-height: 1;
}

.menu-panel {
    position: absolute;
    right: 0;
    top: calc(100% + 8px);
    width: 280px;
    background-color: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    padding: var(--space-2);
    box-shadow: var(--shadow-card-hover);
    z-index: 1000;
}

.panel-header {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3);
}

.avatar-lg {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--color-accent);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 600;
    flex-shrink: 0;
}

.panel-user {
    min-width: 0;
    flex: 1;
}

.panel-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.panel-email {
    font-size: 0.8rem;
    color: var(--color-text-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.panel-divider {
    height: 1px;
    background-color: var(--color-border);
    margin: var(--space-1) 0;
}

.menu-item {
    display: block;
    width: 100%;
    text-align: left;
    background-color: transparent;
    border: none;
    color: var(--color-text-2);
    font-size: 0.9rem;
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-sm);
    text-decoration: none;
    cursor: pointer;
    transition: color 0.15s, background-color 0.15s;
}

.menu-item:hover {
    background-color: var(--color-surface-2);
    color: var(--color-text);
}

.menu-item-danger:hover {
    color: var(--color-error);
}

@media (max-width: 640px) {
    .nav-center {
        display: none;
    }
    .navbar-inner {
        padding: 0 var(--space-4);
    }
}
</style>
