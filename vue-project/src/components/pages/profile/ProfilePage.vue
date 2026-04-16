<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <h4 class="mb-4">Профиль</h4>

                <div class="profile-info mb-4">
                    <div class="info-row">
                        <span class="text-muted-custom small">Имя</span>
                        <span>{{ user.name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-muted-custom small">Email</span>
                        <span>{{ user.email }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="modelSelect" class="form-label">Выберите модель ИИ</label>
                    <select v-model="selectedModel" class="form-select" id="modelSelect">
                        <option v-for="(value, key) in modelsList" :key="key" :value="key">
                            {{ value.name }}
                        </option>
                    </select>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button @click.prevent="selectNewModel" type="button" class="btn btn-accent">
                        Сохранить модель
                    </button>
                    <button @click.prevent="logout" type="button" class="btn btn-ghost btn-logout">
                        Выход
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            modelsList: [],
            selectedModel: null,

            user: {
                name: null,
                email: null
            }
        }
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
            this.$axios.post('/api/profile/setmodel', {
                'newModelName': this.modelsList[this.selectedModel].name,
            }).then(res => {
                console.log(res);
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
.profile-info {
    border-top: 1px solid var(--color-border);
    border-bottom: 1px solid var(--color-border);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-3) 0;
    border-bottom: 1px solid var(--color-border);
}

.info-row:last-child {
    border-bottom: none;
}

.btn-logout:hover {
    color: var(--color-error);
    border-color: var(--color-error);
}
</style>
