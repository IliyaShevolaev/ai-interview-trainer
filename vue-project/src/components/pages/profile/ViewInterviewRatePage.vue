<template>
    <div v-if="authCheck()" class="page">
        <div class="main-container">
            <div class="main-card mb-3" v-for="question in questions" :key="question.id">
                <h2>{{ question.question }}</h2>
                <p>Оценка от ИИ: {{ question.rate }}/10</p>
                <p>{{ question.answer }}</p>

                <button @click.prevent="getFeedback(question.answer_id)" type="button" class="btn btn-outline-light">Спросить пояснение</button>
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

        getFeedback(id) {
            this.$router.push({ name: 'profile.feedback', params: {id: id}});
        },

        authCheck() {
            return localStorage.getItem('auth') === 'true';
        },
    },
}
</script>

<style></style>