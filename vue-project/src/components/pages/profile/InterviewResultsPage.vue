<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card mb-3" v-for="result in paginatedResults" :key="result.id"
                @click="handleClick(result.id)">
                <h2>{{ result.userName }}</h2>
                <p>Оценка от ИИ: {{ result.rate }}/10</p>
                <p>Дата: {{ formatDate(result.timeEnded) }}</p>
            </div>
        </div>

        <div class="pagination">
            <button @click="prevPage" :disabled="currentPage === 1">Назад</button>
            <span>Страница {{ currentPage }} из {{ totalPages }}</span>
            <button @click="nextPage" :disabled="currentPage === totalPages">Вперёд</button>
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
            console.log(res.data.id)
            this.$axios.get(`/api/profile/interviews-manage/results/${res.data.id}`).then(responce => {
                console.log(responce);
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