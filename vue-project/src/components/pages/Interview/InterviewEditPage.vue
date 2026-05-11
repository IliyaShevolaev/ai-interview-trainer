<template>
    <div class="page">
        <div class="container form-container">
            <div class="page-head mb-5">
                <h3 class="mb-1">Редактировать собеседование</h3>
                <p class="text-secondary-2 mb-0">Измените название или набор вопросов</p>
            </div>

            <div v-if="interviewToken" class="card p-4 mb-4 success-card">
                <p class="text-accent-soft small mb-1 success-eyebrow">Сохранено</p>
                <h6 class="mb-3">Изменения применены — ссылка для прохождения</h6>
                <div class="d-flex gap-2">
                    <input type="text" :value="fullInterviewLink" class="form-control" readonly>
                    <button @click="copyLink" class="btn btn-ghost btn-copy">
                        <BootstrapIcon name="copy" size="18" />
                    </button>
                </div>
                <p v-if="copySuccess" class="text-accent-soft small mt-2 mb-0">Ссылка скопирована</p>
            </div>

            <form @submit.prevent="edit">
                <div class="card p-4 mb-3">
                    <h6 class="section-title">Основное</h6>
                    <div class="mb-0">
                        <label for="title" class="form-label">Название</label>
                        <input v-model="name" type="text" class="form-control" id="title"
                            placeholder="Введите название" required>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="section-title mb-0">Вопросы</h6>
                        <span class="badge-muted">{{ questions.length }}</span>
                    </div>

                    <div v-for="(question, index) in questions" :key="index" class="question-row">
                        <span class="question-num">{{ index + 1 }}</span>
                        <input v-model="questions[index]" type="text" class="form-control question-input"
                            :placeholder="`Вопрос ${index + 1}`">
                        <button type="button" class="btn-icon btn-remove"
                            @click="removeQuestion(index)" v-if="questions.length > 1"
                            aria-label="Удалить вопрос">&times;</button>
                    </div>

                    <button type="button" class="btn btn-ghost w-100 btn-add mt-3" @click="addQuestion">
                        + Добавить вопрос
                    </button>
                </div>

                <div class="d-flex justify-content-end align-items-center gap-2">
                    <button type="button" class="btn btn-ghost" @click="$router.back()">
                        Отмена
                    </button>
                    <button type="submit" class="btn btn-accent">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import BootstrapIcon from '@/components/UI/BootstrapIcon.vue';

export default {
    props: {
        token: String,
    },

    components: {
        BootstrapIcon,
    },

    data() {
        return {
            interviewId: null,
            name: '',
            questions: [],
            oldQuestions: [],
            interviewToken: null,
            url: window.location.origin,
            copySuccess: false
        };
    },

    computed: {
        fullInterviewLink() {
            return `${this.url}/interview/${this.interviewToken}`;
        }
    },

    mounted() {
        this.getResult();
    },

    methods: {
        getResult() {
            this.$axios.get(`/api/retokenaize-token/${this.token}`).then(responce => {
                this.$axios.get(`/api/interview/get/${responce.data.id}`).then(res => {
                    this.interviewId = res.data.id;
                    res.data.questions.forEach(question => {
                        this.questions.push(question.text);
                        this.oldQuestions.push(question.text);
                    });
                    this.name = res.data.title;
                });
            })
        },

        addQuestion() {
            this.questions.push('');
        },

        removeQuestion(index) {
            this.questions.splice(index, 1);
        },

        copyLink() {
            navigator.clipboard.writeText(this.fullInterviewLink).then(() => {
                this.copySuccess = true;
                setTimeout(() => this.copySuccess = false, 2000);
            });
        },

        edit() {
            this.questions = this.questions.filter(question => question !== '');

            this.$axios.patch("/api/interview/update", {
                id: this.interviewId,
                title: this.name,
                questions: this.questions,
            }).then(res => {
                this.interviewToken = res.data.token;
            });
        },
    }
};
</script>

<style scoped>
.form-container {
    max-width: 760px;
    padding: var(--space-8) var(--space-4);
}

.page-head h3 {
    font-weight: 700;
}

.section-title {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--color-text-muted);
    margin-bottom: var(--space-3);
}

.question-row {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    margin-bottom: var(--space-2);
}

.question-num {
    flex: 0 0 32px;
    height: 32px;
    border-radius: var(--radius-md);
    background-color: var(--color-surface-2);
    color: var(--color-text-muted);
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
}

.question-input {
    flex: 1 1 auto;
}

.btn-icon {
    flex: 0 0 auto;
    width: 36px;
    height: 36px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: 1px solid transparent;
    border-radius: var(--radius-md);
    color: var(--color-text-muted);
    font-size: 1.4rem;
    line-height: 1;
    cursor: pointer;
    transition: color 0.15s, border-color 0.15s;
}

.btn-icon:hover {
    color: var(--color-error);
    border-color: var(--color-error);
}

.btn-add {
    color: var(--color-text-muted);
    border-style: dashed;
}

.btn-add:hover {
    color: var(--color-accent-text);
    border-color: var(--color-accent);
    border-style: solid;
}

.btn-copy {
    padding: 0.5rem 0.85rem;
    color: var(--color-text-2);
    flex: 0 0 auto;
}

.success-card {
    border-left: 3px solid var(--color-accent);
}

.success-eyebrow {
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
</style>
