<template>
    <div v-if="authCheck()" class="page">
        <div class="main-container">
            <div class="main-card mb-3" v-for="question in questions" :key="question.id">
                <h2>{{ question.question }}</h2>
                <p>Рейтинг: {{ question.rate }}/10</p>
                <p>{{ question.answer }}</p>
            </div>
        </div>
    </div>

    <div v-else class="page">
        <RegisterRequire></RegisterRequire>
    </div>
</template>

<script>
import RegisterRequire from '../../UI/RegisterRequire.vue';

export default {
    props: {
        id: String
    },

    components: {
        RegisterRequire
    },

    data() {
        return {
            questions: []
        }
    },

    mounted() {
        if (this.authCheck()) {
            this.getResult();
        }
    },

    methods: {
        getResult() {
            this.$axios.get(`/api/profile/rate/${this.id}`).then(res => {
                console.log(res);
                this.questions = res.data;
            });
        }, 

        authCheck() {
            return localStorage.getItem('auth') === 'true';
        },
    },
}
</script>

<style></style>