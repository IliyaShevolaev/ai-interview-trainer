<template>
    <div class="page">
        <div class="container profile-container">
            <section class="profile-hero">
                <div class="hero-avatar">{{ initial }}</div>
                <h2 class="hero-name">{{ user.name || '—' }}</h2>
                <p class="hero-email text-muted-custom">{{ user.email }}</p>
            </section>

            <section class="mb-4">
                <div class="section-head">
                    <h6 class="section-title">Модель ИИ</h6>
                    <p class="section-sub text-secondary-2">
                        Выберите модель, которая будет оценивать ваши ответы.
                    </p>
                </div>

                <div class="card p-4">
                    <label for="modelSelect" class="form-label">Активная модель</label>
                    <select v-model="selectedModel" class="form-select mb-3" id="modelSelect">
                        <option v-for="(value, key) in modelsList" :key="key" :value="key">
                            {{ value.name }}
                        </option>
                    </select>

                    <div class="d-flex justify-content-end">
                        <button @click.prevent="selectNewModel" type="button" class="btn btn-accent"
                            :disabled="savingModel">
                            {{ savingModel ? 'Сохранение…' : 'Сохранить' }}
                        </button>
                    </div>
                    <p v-if="saveSuccess" class="text-accent-soft small mt-2 mb-0">Модель сохранена</p>
                </div>
            </section>

            <section>
                <div class="section-head">
                    <h6 class="section-title">Аккаунт</h6>
                    <p class="section-sub text-secondary-2">
                        Управление сессией.
                    </p>
                </div>

                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                        <div>
                            <div style="font-weight: 500;">Выход из аккаунта</div>
                            <div class="text-muted-custom small">Вы будете перенаправлены на страницу входа.</div>
                        </div>
                        <button @click.prevent="logout" type="button" class="btn btn-ghost btn-logout">
                            Выйти
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            modelsList: [],
            selectedModel: null,
            savingModel: false,
            saveSuccess: false,

            user: {
                name: null,
                email: null
            }
        }
    },

    computed: {
        initial() {
            const source = this.user.name || this.user.email || '?';
            return source.charAt(0).toUpperCase();
        },
    },

    mounted() {
        this.getModels();
        this.getUser();
    },

    methods: {
        getUser() {
            this.$axios.get('/api/user').then(res => {
                this.user.name = res.data.name;
                this.user.email = res.data.email;
            })
        },

        getModels() {
            this.$axios.get('/api/profile/modelslist').then(res => {
                this.modelsList = res.data;

                for (let i = 0; i < this.modelsList.length; i++) {
                    if (this.modelsList[i].isSelected) {
                        this.selectedModel = i;
                        break;
                    }
                }
            });
        },

        selectNewModel() {
            this.savingModel = true;
            this.saveSuccess = false;
            this.$axios.post('/api/profile/setmodel', {
                'newModelName': this.modelsList[this.selectedModel].name,
            }).then(() => {
                this.savingModel = false;
                this.saveSuccess = true;
                setTimeout(() => this.saveSuccess = false, 2000);
            });
        },

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

<style scoped>
.profile-container {
    max-width: 640px;
    padding: var(--space-10) var(--space-4) var(--space-12);
}

.profile-hero {
    text-align: center;
    padding: var(--space-6) 0 var(--space-10);
}

.hero-avatar {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background-color: var(--color-accent);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2.25rem;
    font-weight: 600;
    margin-bottom: var(--space-4);
    line-height: 1;
}

.hero-name {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: var(--space-1);
    color: var(--color-text);
}

.hero-email {
    font-size: 0.9rem;
    margin-bottom: 0;
}

.section-head {
    margin-bottom: var(--space-3);
    padding-left: var(--space-1);
}

.section-title {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--color-text-muted);
    margin-bottom: var(--space-1);
}

.section-sub {
    font-size: 0.85rem;
    margin-bottom: 0;
}

.btn-logout:hover {
    color: var(--color-error);
    border-color: var(--color-error);
}
</style>
