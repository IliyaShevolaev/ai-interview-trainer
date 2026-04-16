<template>
    <div class="page">
        <div v-if="!inProcess" class="main-container">
            <div class="main-card text-center">
                <div v-if="questions">
                    <h3 class="mb-3">{{ title }}</h3>
                    <p class="text-secondary-2 mb-4">
                        Содержит {{ questions.length }} {{ questionsWord }}. Готовы начать?
                    </p>
                    <button @click.prevent="startInterview" type="button" class="btn btn-accent">
                        Начать
                    </button>
                </div>
            </div>
        </div>

        <div v-else class="container interview-container">
            <div class="d-flex align-items-center gap-3 mb-4">
                <span class="text-muted-custom small" style="white-space: nowrap">
                    Вопрос {{ questionId + 1 }} из {{ questions.length }}
                </span>
                <div class="progress flex-grow-1" style="height: 6px;">
                    <div class="progress-bar" :style="{ width: progressPct + '%' }"></div>
                </div>
            </div>

            <div class="card p-4 mb-3">
                <p class="question-text mb-4">{{ questions[questionId]['text'] }}</p>

                <textarea v-if="!userAnswers[questionId]" v-model="answer" placeholder="Ваш ответ..."
                    class="form-control mb-3" rows="5"></textarea>
                <textarea v-else class="form-control mb-3" disabled rows="5">{{ userAnswers[questionId] }}</textarea>

                <div class="d-flex flex-wrap gap-2">
                    <button @click.prevent="startRecognition" type="button" class="btn btn-ghost">
                        Записать
                    </button>
                    <button @click.prevent="startRecognition(false)" type="button" class="btn btn-ghost">
                        Добавить запись
                    </button>
                    <button @click.prevent="sendAnswer" v-if="!userAnswers[questionId] && !isAiThinking"
                        type="button" class="btn btn-accent ms-auto">
                        Отправить ответ
                    </button>

                    <div class="tooltip-container ms-auto"
                        @mouseenter="showTooltip = true" @mouseleave="showTooltip = false"
                        v-if="userAnswers[questionId] && !isAiThinking && !interviewFinished">
                        <button @click.prevent="bugReport" type="button" class="btn btn-ghost btn-bug">
                            <BootstrapIcon name="bug" size="18" />
                        </button>
                        <div v-if="showTooltip" class="custom-tooltip">
                            Нажмите, чтобы повторно оценить ответ, если считаете оценку ИИ некорректной.
                        </div>
                    </div>
                </div>

                <div v-if="isAiThinking" class="mt-4 text-secondary-2">
                    ИИ обдумывает ответ...
                </div>

                <div v-if="aiRates[questionId]" class="ai-rating mt-4">
                    <div class="text-accent-soft small mb-2" style="font-weight: 600;">Оценка ИИ</div>
                    <p class="mb-0">{{ aiRates[questionId] }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button @click="prevQuestion" class="btn btn-ghost" :disabled="questionId === 0">
                    ← Назад
                </button>
                <button @click="nextQuestion" class="btn btn-ghost"
                    :disabled="questionId >= questions.length - 1">
                    Вперёд →
                </button>
            </div>

            <div class="text-center mt-5" v-if="userAnswers.length == questions.length && !interviewFinished">
                <button @click="finishInterview" class="btn btn-accent btn-lg">
                    Завершить собеседование
                </button>
            </div>

            <div v-if="interviewFinished" class="card p-4 mt-5 text-center finish-card">
                <h5 class="mb-2">Собеседование завершено</h5>
                <p class="text-secondary-2 mb-3">Итоговая оценка</p>
                <div class="final-rate text-accent">{{ finalRate }}/10</div>
                <p class="text-muted-custom small mt-3 mb-0">
                    Ваши данные отправлены создателю собеседования.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import BootstrapIcon from '@/components/UI/BootstrapIcon.vue';

export default {
    props: {
        token: String
    },

    components: {
        BootstrapIcon,
    },

    data() {
        return {
            interviewId: null,
            title: null,
            questions: null,

            inProcess: false,
            interviewFinished: false,
            questionId: 0,

            answer: "",
            userAnswers: [],
            aiRates: [],

            finalRate: 0,
            showTooltip: false,
            isAiThinking: false,
        };
    },

    computed: {
        progressPct() {
            if (!this.questions) return 0;
            return ((this.questionId + 1) / this.questions.length) * 100;
        },
        questionsWord() {
            const n = this.questions.length;
            if (n % 10 === 1 && n % 100 !== 11) return 'вопрос';
            if ([2, 3, 4].includes(n % 10) && ![12, 13, 14].includes(n % 100)) return 'вопроса';
            return 'вопросов';
        },
    },

    mounted() {
        this.getInterviewDataByToken(this.token);
    },

    methods: {
        getInterviewData(id) {
            this.$axios.get(`/api/interview/get/${id}`).then(res => {
                this.interviewId = res.data.id;
                this.title = res.data.title;
                this.questions = res.data.questions;
            })
        },

        getInterviewDataByToken(token) {
            this.$axios.get(`/api/retokenaize-token/${token}`).then(res => {
                this.getInterviewData(res.data.id);
            }).catch(error => {
                console.log(error);
            });
        },

        startInterview() {
            this.inProcess = true;
        },

        startRecognition(isStart = true) {
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = "ru-RU";
            recognition.start();

            recognition.onresult = (speech) => {
                isStart ? this.answer = speech.results[0][0].transcript : this.answer += ' ' + speech.results[0][0].transcript
                recognition.stop();
            };

            recognition.onerror = (event) => {
                console.error(event.error);
            };
        },

        sendAnswer() {
            this.isAiThinking = true;
            this.$axios.post('/api/interview/rate-answer', {
                interviewTitle: this.title,
                question: this.questions[this.questionId]['text'],
                answer: this.answer,
            }).then(res => {
                this.aiRates[this.questionId] = res.data.rate;
                this.userAnswers[this.questionId] = this.answer
                this.isAiThinking = false;
            });
        },

        bugReport() {
            this.isAiThinking = true;
            this.$axios.post('/api/report', {
                question_id: this.questions[this.questionId]['id'],
                answer: this.answer,
                aiRate: this.aiRates[this.questionId],
            }).then(res => {
                console.log(res);
                this.sendAnswer();
            });
        },

        nextQuestion() {
            if (this.questionId < this.questions.length - 1) {
                this.questionId++;
                this.answer = "";
            }
        },

        prevQuestion() {
            if (this.questionId > 0) {
                this.questionId--;
            }
        },

        finishInterview() {
            this.$axios.post('/api/interview/finish', {
                answers: this.userAnswers,
                rates: this.aiRates,
                questions: this.questions,
                interview_id: this.interviewId,
            }).then(res => {
                this.finalRate = res.data.rate;
                this.interviewFinished = true;
            });
        },
    },
};
</script>

<style scoped>
.interview-container {
    max-width: 800px;
    padding: var(--space-8) var(--space-4);
}

.question-text {
    font-size: 1.1rem;
    font-weight: 500;
    color: var(--color-text);
    line-height: 1.5;
}

.ai-rating {
    padding-left: var(--space-4);
    border-left: 3px solid var(--color-accent);
    color: var(--color-text-2);
}

.btn-bug {
    padding: 6px 10px;
    color: var(--color-text-muted);
}

.btn-bug:hover {
    color: var(--color-warning);
    border-color: var(--color-warning);
}

.tooltip-container {
    position: relative;
    display: inline-block;
}

.custom-tooltip {
    position: absolute;
    bottom: calc(100% + 8px);
    right: 0;
    background-color: var(--color-surface-2);
    border: 1px solid var(--color-border);
    color: var(--color-text-2);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-md);
    font-size: 0.8rem;
    width: 260px;
    z-index: 10;
    box-shadow: var(--shadow-card);
}

.finish-card {
    border-left: 3px solid var(--color-accent);
}

.final-rate {
    font-size: 2.5rem;
    font-weight: 700;
}
</style>
