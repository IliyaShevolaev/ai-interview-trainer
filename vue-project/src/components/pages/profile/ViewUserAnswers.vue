<template>
    <div class="page">
        <div class="container rate-container">
            <h4 class="mb-4">Ответы пользователя</h4>

            <div class="d-flex flex-column gap-3">
                <div class="card p-4" v-for="question in questions" :key="question.id">
                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
                        <h6 class="mb-0 question-title">{{ question.question }}</h6>
                        <span class="badge-accent">{{ question.rate }}/10</span>
                    </div>

                    <div class="answer-block">
                        <div class="text-muted-custom small mb-1">Ответ</div>
                        <p class="mb-0 text-secondary-2">{{ question.answer }}</p>
                    </div>
                </div>
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
            this.questions = res.data;
        })
    },
}
</script>

<style scoped>
.rate-container {
    max-width: 900px;
    padding: var(--space-8) var(--space-4);
}

.question-title {
    font-weight: 600;
    line-height: 1.4;
    flex: 1;
    min-width: 0;
}

.answer-block {
    padding: var(--space-3);
    background-color: var(--color-surface-2);
    border-radius: var(--radius-md);
}
</style>
