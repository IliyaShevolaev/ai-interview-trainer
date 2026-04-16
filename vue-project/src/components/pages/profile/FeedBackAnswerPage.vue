<template>
    <div class="page">
        <div class="container feedback-container">
            <div v-if="question" class="card p-4">
                <h5 class="mb-3">{{ question }}</h5>

                <div class="answer-block mb-3">
                    <div class="text-muted-custom small mb-1">Ваш ответ</div>
                    <p class="mb-0 text-secondary-2">{{ userAnswer }}</p>
                </div>

                <div v-if="aiFeedback" class="feedback-block mb-3">
                    <div class="text-accent-soft small mb-2" style="font-weight: 600;">Пояснение ИИ</div>
                    <p class="mb-0">{{ aiFeedback }}</p>
                </div>

                <div v-if="aiIsThinking" class="text-secondary-2 mb-3">
                    ИИ обдумывает ответ...
                </div>

                <button v-if="!aiIsThinking" @click.stop="getFeedback" type="button" class="btn btn-ghost">
                    <BootstrapIcon name="restart" size="16" /> Спросить ещё раз
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import BootstrapIcon from '@/components/UI/BootstrapIcon.vue';

export default {
    props: {
        id: String,
    },

    components: {
        BootstrapIcon,
    },

    data() {
        return {
            question: '',
            userAnswer: '',
            aiFeedback: '',

            aiIsThinking: false,
        }
    },

    mounted() {
        this.getFeedback();
    },

    methods: {
        getFeedback() {
            this.aiIsThinking = true;
            this.$axios.get(`/api/feedback/${this.id}`).then(res => {
                this.question = res.data.question;
                this.userAnswer = res.data.answer;
                this.aiFeedback = res.data.feedback;
                this.aiIsThinking = false;
            })
        }
    },
}
</script>

<style scoped>
.feedback-container {
    max-width: 800px;
    padding: var(--space-8) var(--space-4);
}

.answer-block {
    padding: var(--space-3);
    background-color: var(--color-surface-2);
    border-radius: var(--radius-md);
}

.feedback-block {
    padding: var(--space-4);
    border-left: 3px solid var(--color-accent);
    color: var(--color-text);
    line-height: 1.6;
}

.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    align-self: flex-start;
}
</style>
