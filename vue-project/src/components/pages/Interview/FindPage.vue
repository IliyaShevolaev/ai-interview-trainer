<template>
    <div class="page">
        <div class="main-container">
            <div v-if="!this.findCompleted" class="main-card-find mb-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-input" placeholder="Поиск..." v-model="searchQuery">
                    <button @click.prevent="makeFindQuery" class="btn btn-outline-light " type="button">
                        <BootstrapIcon name="search" size="24" />
                    </button>
                </div>
            </div>

            <div v-else class="main-card mb-3" v-for="interview in paginatedResults" :key="interview.id"
                @click="handleClick(interview.token)">
                <h2>
                    {{ interview.title }} <span style="font-size: 0.5em;">by {{ interview.username }}</span>
                    <p>Содержит вопросов: {{ interview.questionsCount }}.</p> 
                </h2>
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
            perPage: 3,
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
                console.log(res);
                this.interviews = res.data.data;
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

.main-card-find {
    background-color: #1f1f1f;
    border: none;
    padding: 30px;
    border-radius: 10px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.main-card-find p {
    font-size: 18px;
    color: #e0e0e0;
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

.search-input {
    background-color: #2a2a2a;
    border-color: #ffffff;
    color: #ffffff;
    outline: none;
    border: 2px solid #444;
}

.search-input:focus {
    background-color: #2a2a2a;
    border-color: #ffffff;
    color: #ffffff;
    outline: none;
}

.search-input::placeholder {
    color: #bbbbbb;
}
</style>