<template>
    <div class="page">
        <div class="container find-container">
            <div class="d-flex gap-2 mb-4">
                <input type="text" class="form-control" placeholder="Поиск собеседований..."
                    v-model="searchQuery" @keyup.enter="makeFindQuery">
                <button @click.prevent="makeFindQuery" class="btn btn-accent search-btn" type="button">
                    <BootstrapIcon name="search" size="18" />
                </button>
            </div>

            <div v-if="findCompleted && interviews.length === 0" class="text-center text-secondary-2 py-5">
                Ничего не найдено
            </div>

            <div v-if="findCompleted" class="d-flex flex-column gap-3">
                <div class="card p-4 interview-card" v-for="interview in paginatedResults" :key="interview.id"
                    @click="handleClick(interview.token)">
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                        <h5 class="mb-0">{{ interview.title }}</h5>
                        <span class="badge-muted">by {{ interview.username }}</span>
                    </div>
                    <div class="d-flex gap-3 text-secondary-2 small">
                        <span>Вопросов: {{ interview.questionsCount }}</span>
                        <span>Прошли: {{ interview.completedCount }}</span>
                    </div>
                </div>
            </div>

            <div v-if="findCompleted && totalPages > 1" class="pagination-wrap">
                <button @click="prevPage" :disabled="currentPage === 1" class="btn btn-ghost">
                    Назад
                </button>
                <span class="text-muted-custom small">Страница {{ currentPage }} из {{ totalPages }}</span>
                <button @click="nextPage" :disabled="currentPage === totalPages" class="btn btn-ghost">
                    Вперёд
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import BootstrapIcon from '@/components/UI/BootstrapIcon.vue';

export default {
    components: {
        BootstrapIcon,
    },

    data() {
        return {
            interviews: [],

            searchQuery: '',
            findCompleted: false,

            currentPage: 1,
            perPage: 6,
        }
    },

    computed: {
        totalPages() {
            return Math.ceil(this.interviews.length / this.perPage);
        },

        paginatedResults() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.interviews.slice(start, start + this.perPage);
        }
    },

    methods: {
        makeFindQuery() {
            this.findCompleted = true;

            this.$axios.post('/api/interview/find', {
                searchQuery: this.searchQuery,
            }).then(res => {
                this.interviews = res.data;
            })
        },

        handleClick(token) {
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
    },
}
</script>

<style scoped>
.find-container {
    max-width: 800px;
    padding: var(--space-8) var(--space-4);
}

.search-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 var(--space-4);
}

.interview-card {
    cursor: pointer;
    transition: border-color 0.15s, box-shadow 0.15s;
}

.interview-card:hover {
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
</style>
