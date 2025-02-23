<template>
    <div v-if="this.authCheck()" class="page">
        <div class="main-container">
            <div class="main-card mb-3" v-for="result in results" :key="result.id" @click="handleClick(result)">
                <h2>{{ result.title }}</h2>
                <p>Рейтинг: {{ result.rate }}/10</p>
                <p>Дата: {{ formatDate(result.timeEnded) }}</p>
            </div>
        </div>
    </div>

    <div v-else class="page">
        <div class="main-container">
            <div class="main-card mb-3">
                <p>Необходима <router-link to="/auth" type="button" class="btn btn-outline-light">регистрация</router-link>, для просмотра результатов</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            results: [],
        };
    },

    mounted() {
        if (this.authCheck()) {
            this.getResults();
        }
    },

    methods: {
        handleClick(item) {
            alert(`Вы выбрали: ${item.title}`);
        },

        getResults() {
            this.$axios.get('/api/profile/my-results').then(res => {
                console.log(res);
                this.results = res.data;
            })
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
</style>