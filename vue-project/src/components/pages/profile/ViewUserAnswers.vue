<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card mb-3" v-for="question in questions" :key="question.id">
                <h2>{{ question.question }}</h2>
                <p>Ответ: {{ question.answer }}</p>
                <p>Оценка от ИИ: {{ question.rate }}/10</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        id: String
    },

    data() {
        return {
            questions: []
        }
    },

    mounted() {
        this.$axios.get(`/api/profile/interviews-manage/user-answers/${this.id}`).then(res => {
            console.log(res);
            this.questions = res.data;
        })
    },
}
</script>
<style>
    
</style>