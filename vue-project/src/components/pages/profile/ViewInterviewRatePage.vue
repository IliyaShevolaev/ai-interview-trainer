<template>
    <div v-if="authCheck()" class="page">
        <div class="container rate-container">
            <h4 class="mb-4">Детали результата</h4>

            <div class="d-flex flex-column gap-3">
                <div class="card p-4" v-for="question in questions" :key="question.id">
                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
                        <h6 class="mb-0 question-title">{{ question.question }}</h6>
                        <span class="badge-accent">{{ question.rate }}/10</span>
                    </div>

                    <div class="answer-block mb-3">
                        <div class="text-muted-custom small mb-1">Ваш ответ</div>
                        <p class="mb-0 text-secondary-2">{{ question.answer }}</p>
                    </div>

                    <button @click.prevent="getFeedback(question.answer_id)" type="button"
                        class="btn btn-ghost btn-sm">
                        Спросить пояснение
                    </button>
                </div>
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
                this.questions = res.data;
            });
        },

        getFeedback(id) {
            this.$router.push({ name: 'profile.feedback', params: { id: id } });
        },

        authCheck() {
            return localStorage.getItem('auth') === 'true';
        },
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

.btn-sm {
    padding: 0.4rem 0.85rem;
    font-size: 0.85rem;
    align-self: flex-start;
}
</style>
