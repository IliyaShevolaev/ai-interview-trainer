<template>
    <div v-if="authCheck()" class="page">
        <div class="main-container">
            <div class="main-card mb-3" v-for="result in paginatedResults" :key="result.id">
                <h2>{{ result.title }}</h2>
                <p>Прошли: {{ result.completedCount }}</p>
                <p>Создано: {{ formatDate(result.created_at) }}</p>

                <div class="btn-container">
                    <button type="btn" class="btn btn-outline-light" @click.prevent="shareLink(result.token)">Поделиться</button>
                    <button type="btn" class="btn btn-outline-warning" @click.prevent="shareLink(result.token)">Редактировать</button>
                    <button type="btn" class="btn btn-outline-success" @click.prevent="goToResults(result.token)">Результаты</button>
                </div>
            </div>
        </div>

        <div class="pagination">
            <button @click="prevPage" :disabled="currentPage === 1">Назад</button>
            <span>Страница {{ currentPage }} из {{ totalPages }}</span>
            <button @click="nextPage" :disabled="currentPage === totalPages">Вперёд</button>
        </div>
    </div>

    <div v-else class="page">
        <RegisterRequire></RegisterRequire>
    </div>
</template>

<script>
import RegisterRequire from '../../UI/RegisterRequire.vue';

export default {
    components: {
        RegisterRequire
    },
    
    data() {
        return {
            results: [],
            currentPage: 1,
            perPage: 3,
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
                console.log(res);
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

            navigator.clipboard.writeText(url).then(() => {}).catch(err => {
                console.error(err);
            });
        }
    }
};
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 15px;
    gap: 10px;
}

.pagination button {
    padding: 5px 10px;
    border: none;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    border-radius: 5px;
}

.pagination button:disabled {
    background-color: #6c757d;
    cursor: not-allowed;
}

.btn-container {
    display: flex;
    justify-content: space-around;
}

</style>
