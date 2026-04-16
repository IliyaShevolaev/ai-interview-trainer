<template>
    <div class="page">
        <div class="container rates-container">
            <h4 class="mb-4">Результаты прохождения</h4>

            <div v-if="results.length === 0" class="text-center text-secondary-2 py-5">
                Никто ещё не прошёл это собеседование
            </div>

            <div class="d-flex flex-column gap-3">
                <div class="card p-4 result-card" v-for="result in paginatedResults" :key="result.id"
                    @click="handleClick(result.id)">
                    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                        <h5 class="mb-0">{{ result.userName }}</h5>
                        <div class="d-flex gap-3 text-secondary-2 small flex-wrap">
                            <span>Оценка: <span class="text-accent-soft">{{ result.rate }}/10</span></span>
                            <span>{{ formatDate(result.timeEnded) }}</span>
                        </div>
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
</template>

<script>
import RegisterRequire from '../../UI/RegisterRequire.vue';

export default {
    props: {
        token: String
    },

    components: {
        RegisterRequire
    },

    data() {
        return {
            results: [],
            currentPage: 1,
            perPage: 10,
        }
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
        this.$axios.get(`/api/retokenaize-token/${this.token}`).then(res => {
            this.$axios.get(`/api/profile/interviews-manage/results/${res.data.id}`).then(responce => {
                this.results = responce.data;
            })
        });
    },

    methods: {
        handleClick(id) {
            this.$router.push({ name: 'profile.interview.manage.answers', params: { id: id } });
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

        formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = String(date.getFullYear()).slice(2);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${day}/${month}/${year} ${hours}:${minutes}`;
        },
    },
}
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
</style>
