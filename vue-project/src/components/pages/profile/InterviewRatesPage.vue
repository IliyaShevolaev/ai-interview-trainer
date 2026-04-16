<template>
    <div v-if="authCheck()" class="page">
        <div class="container rates-container">
            <h4 class="mb-4">Мои результаты</h4>

            <div v-if="results.length === 0" class="text-center text-secondary-2 py-5">
                Вы ещё не проходили собеседований
            </div>

            <div class="d-flex flex-column gap-3">
                <div class="card p-4 result-card" v-for="result in paginatedResults" :key="result.id"
                    @click="handleClick(result.id)">
                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                        <div>
                            <h5 class="mb-2">{{ result.title }}</h5>
                            <div class="d-flex gap-3 text-secondary-2 small flex-wrap">
                                <span>Оценка: <span class="text-accent-soft">{{ result.rate }}/10</span></span>
                                <span>{{ formatDate(result.timeEnded) }}</span>
                            </div>
                        </div>
                        <button @click.stop="restart(result.token)" type="button" class="btn btn-ghost btn-sm">
                            <BootstrapIcon name="restart" size="16" /> Пройти ещё раз
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="totalPages > 1" class="pagination-wrap">
                <button @click="prevPage" :disabled="currentPage === 1" class="btn btn-ghost">Назад</button>
                <span class="text-muted-custom small">Страница {{ currentPage }} из {{ totalPages }}</span>
                <button @click="nextPage" :disabled="currentPage === totalPages" class="btn btn-ghost">Вперёд</button>
            </div>
        </div>
    </div>

    <div v-else class="page">
        <RegisterRequire></RegisterRequire>
    </div>
</template>

<script>
import RegisterRequire from '../../UI/RegisterRequire.vue';
import BootstrapIcon from '@/components/UI/BootstrapIcon.vue';

export default {
    components: {
        RegisterRequire,
        BootstrapIcon,
    },

    data() {
        return {
            results: [],
            currentPage: 1,
            perPage: 6,
        };
    },

    computed: {
        totalPages() {
            return Math.ceil(this.results.length / this.perPage);
        },

        paginatedResults() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.results.slice(start, start + this.perPage);
        }
    },

    mounted() {
        if (this.authCheck()) {
            this.getResults();
        }
    },

    methods: {
        handleClick(id) {
            this.$router.push({ name: 'profile.rate', params: { id: id } });
        },

        getResults() {
            this.$axios.get('/api/profile/my-results').then(res => {
                this.results = res.data;
            });
        },

        authCheck() {
            return localStorage.getItem('auth') === 'true';
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = String(date.getFullYear()).slice(2);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${day}/${month}/${year} ${hours}:${minutes}`;
        },

        restart(token) {
            this.$router.push({ name: 'interview.start', params: { token: token } });
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        }
    }
};
</script>

<style scoped>
.rates-container {
    max-width: 900px;
    padding: var(--space-8) var(--space-4);
}

.result-card {
    cursor: pointer;
    transition: border-color 0.15s, box-shadow 0.15s;
}

.result-card:hover {
    border-color: var(--color-border-strong) !important;
    box-shadow: var(--shadow-card-hover);
}

.pagination-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: var(--space-8);
    gap: var(--space-4);
}

.btn-sm {
    padding: 0.35rem 0.75rem;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
}
</style>
