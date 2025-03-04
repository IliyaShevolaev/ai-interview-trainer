<template>
    <div v-if="authCheck()" class="page">
        <div class="main-container">
            <div class="main-card mb-3" v-for="result in paginatedResults" :key="result.id"
                @click="handleClick(result.id)">
                <h2>{{ result.title }}</h2>
                <p>Оценка от ИИ: {{ result.rate }}/10</p>
                <p>Дата: {{ formatDate(result.timeEnded) }}</p>

                <button @click.stop="restart(result.token)" type="button" class="btn btn-outline-light">Restart <BootstrapIcon name="restart" size="24"/></button>
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
        handleClick(id) {
            this.$router.push({ name: 'profile.rate', params: { id: id } });
        },

        getResults() {
            this.$axios.get('/api/profile/my-results').then(res => {
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
.main-card {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.main-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
}

.main-card h2 {
    color: #ffffff;
    margin-bottom: 10px;
}

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
</style>
