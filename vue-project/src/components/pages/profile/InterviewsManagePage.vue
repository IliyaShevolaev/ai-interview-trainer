<template>
    <div v-if="authCheck()" class="page">
        <div class="container manage-container">
            <h4 class="mb-4">Мои собеседования</h4>

            <div v-if="results.length === 0" class="text-center text-secondary-2 py-5">
                Вы ещё не создавали собеседований
            </div>

            <div class="d-flex flex-column gap-3">
                <div class="card p-4" v-for="result in paginatedResults" :key="result.id">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
                        <div>
                            <h5 class="mb-2">{{ result.title }}</h5>
                            <div class="d-flex gap-3 text-secondary-2 small flex-wrap">
                                <span>Прошли: {{ result.completedCount }}</span>
                                <span>Создано: {{ formatDate(result.created_at) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-ghost btn-sm"
                            @click.prevent="shareLink(result.token)">
                            <BootstrapIcon name="copy" size="16" /> Поделиться
                        </button>
                        <button type="button" class="btn btn-ghost btn-sm"
                            @click.prevent="editInterview(result.token)">
                            <BootstrapIcon name="edit" size="16" /> Редактировать
                        </button>
                        <button type="button" class="btn btn-accent btn-sm"
                            @click.prevent="goToResults(result.token)">
                            <BootstrapIcon name="result-list" size="16" /> Результаты
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
        goToResults(token) {
            this.$router.push({ name: 'profile.interview.manage.result', params: { token: token } });
        },

        getResults() {
            this.$axios.get('/api/profile/interviews-manage').then(res => {
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

        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },

        shareLink(token) {
            const url = `${window.location.origin}/interview/${token}`;

            navigator.clipboard.writeText(url).then(() => { }).catch(err => {
                console.error(err);
            });
        },

        editInterview(token) {
            this.$router.push({ name: 'profile.interview.manage.edit', params: { token: token } });
        },
    }
};
</script>

<style scoped>
.manage-container {
    max-width: 900px;
    padding: var(--space-8) var(--space-4);
}

.pagination-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: var(--space-8);
    gap: var(--space-4);
}

.btn-sm {
    padding: 0.4rem 0.85rem;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
}
</style>
