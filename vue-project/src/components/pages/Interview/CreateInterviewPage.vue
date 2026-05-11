<template>
    <div class="page">
        <div class="container form-container">
            <div class="page-head mb-5">
                <h3 class="mb-1">Создать собеседование</h3>
                <p class="text-secondary-2 mb-0">Добавьте вопросы и поделитесь ссылкой с участниками</p>
            </div>

            <div v-if="interviewToken" class="card p-4 mb-4 success-card">
                <p class="text-accent-soft small mb-1 success-eyebrow">Готово</p>
                <h6 class="mb-3">Собеседование создано — вот ссылка для прохождения</h6>
                <div class="d-flex gap-2">
                    <input type="text" :value="fullInterviewLink" class="form-control" readonly>
                    <button @click="copyLink" class="btn btn-ghost btn-copy">
                        <BootstrapIcon name="copy" size="18" />
                    </button>
                </div>
                <p v-if="copySuccess" class="text-accent-soft small mt-2 mb-0">Ссылка скопирована</p>
            </div>

            <form @submit.prevent="create">
                <div class="card p-4 mb-3">
                    <h6 class="section-title">Основное</h6>

                    <div class="mb-4">
                        <label for="title" class="form-label">Название</label>
                        <input v-model="name" type="text" class="form-control" id="title"
                            placeholder="Например, Frontend Junior" required>
                    </div>

                    <div class="access-row">
                        <div>
                            <div class="access-label">Доступ</div>
                            <p class="text-muted-custom small mb-0">
                                {{ isPublic ? 'Виден всем в каталоге' : 'Только по прямой ссылке' }}
                            </p>
                        </div>
                        <div class="form-check form-switch m-0 access-toggle">
                            <input class="form-check-input" type="checkbox" id="publicSwitch" v-model="isPublic">
                        </div>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <h6 class="section-title">Генерация вопросов с ИИ</h6>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Тема</label>
                            <input
                                v-model="generateForm.topic"
                                type="text"
                                class="form-control"
                                placeholder="Например, JavaScript"
                            >
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Количество</label>
                            <input
                                v-model.number="generateForm.questionsCount"
                                type="number"
                                min="1"
                                max="20"
                                class="form-control"
                            >
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Уровень</label>
                            <input
                                v-model="generateForm.level"
                                type="text"
                                class="form-control"
                                placeholder="Junior / Middle / Senior"
                            >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Пожелания</label>
                        <textarea
                            v-model="generateForm.wishes"
                            class="form-control"
                            rows="3"
                            placeholder="Например, добавить пару практических вопросов"
                        ></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button
                            type="button"
                            class="btn btn-ghost"
                            :disabled="generatingQuestions || !authCheck()"
                            @click="generateQuestions"
                        >
                            {{ generatingQuestions ? 'Генерация...' : 'Сгенерировать вопросы' }}
                        </button>
                    </div>

                    <p v-if="generatingError" class="text-danger small mt-2 mb-0">{{ generatingError }}</p>
                    <p v-if="generateSuccess" class="text-accent-soft small mt-2 mb-0">Вопросы сгенерированы</p>
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
                    <button v-if="authCheck() && !interviewToken" type="submit" class="btn btn-accent" :disabled="isCreating">
                        {{ isCreating ? 'Создание...' : 'Создать' }}
                    </button>
                    <router-link v-if="!authCheck()" to="/auth" class="btn btn-accent">
                        Войти
                    </router-link>
                </div>
                <p v-if="!authCheck()" class="text-muted-custom small text-end mt-2 mb-0">
                    Для создания необходима регистрация
                </p>
            </form>
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
            name: '',
            questions: [''],
            isPublic: false,
            interviewToken: null,
            url: window.location.origin,
            copySuccess: false,
            isCreating: false,
            generatingQuestions: false,
            generatingError: null,
            generateSuccess: false,
            generateForm: {
                topic: '',
                questionsCount: 5,
                level: 'Middle',
                wishes: '',
            }
        };
    },
    computed: {
        fullInterviewLink() {
            return `${this.url}/interview/${this.interviewToken}`;
        }
    },
    methods: {
        authCheck() {
            return localStorage.getItem('auth') === 'true';
        },

        addQuestion() {
            this.questions.push('');
        },

        removeQuestion(index) {
            this.questions.splice(index, 1);
        },

        async generateQuestions() {
            if (!this.authCheck()) {
                this.generatingError = 'Для генерации вопросов необходимо войти в аккаунт';
                this.generateSuccess = false;
                return;
            }

            this.generatingError = null;
            this.generateSuccess = false;
            this.generatingQuestions = true;

            try {
                const payload = {
                    topic: this.generateForm.topic.trim(),
                    questionsCount: Number(this.generateForm.questionsCount),
                    level: this.generateForm.level.trim(),
                    wishes: this.generateForm.wishes.trim(),
                };

                const res = await this.$axios.post('/api/interview/generate-questions', payload);
                const generatedQuestions = Array.isArray(res.data.questions) ? res.data.questions : [];
                const questionsList = generatedQuestions
                    .map((question) => String(question).trim())
                    .filter((question) => question !== '');

                if (questionsList.length === 0) {
                    this.generatingError = 'Не удалось получить вопросы. Попробуйте еще раз';
                    return;
                }

                this.questions = questionsList;
                this.generateSuccess = true;
            } catch (error) {
                const validationErrors = error?.response?.data?.errors;
                if (validationErrors && typeof validationErrors === 'object') {
                    const firstError = Object.values(validationErrors)[0];
                    if (Array.isArray(firstError) && firstError.length > 0) {
                        this.generatingError = firstError[0];
                        return;
                    }
                }

                this.generatingError = error?.response?.data?.message || 'Ошибка генерации вопросов';
            } finally {
                this.generatingQuestions = false;
            }
        },

        async create() {
            if (this.isCreating) {
                return;
            }

            this.isCreating = true;
            let questionsList = [];
            this.questions.forEach((question) => {
                if (question !== '') {
                    questionsList.push(question);
                }
            });

            try {
                const res = await this.$axios.post("/api/interview/store", {
                    'title': this.name,
                    'questions': questionsList,
                    'isPublic': this.isPublic,
                });

                this.interviewToken = res.data.token;
            } finally {
                this.isCreating = false;
            }
        },

        copyLink() {
            navigator.clipboard.writeText(this.fullInterviewLink).then(() => {
                this.copySuccess = true;
                setTimeout(() => this.copySuccess = false, 2000);
            });
        }
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

.access-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-4);
    padding-top: var(--space-4);
    border-top: 1px solid var(--color-border);
}

.access-label {
    color: var(--color-text);
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: var(--space-1);
}

.access-toggle .form-check-input {
    cursor: pointer;
    width: 2.5em;
    height: 1.35em;
    background-color: var(--color-surface-2);
    border-color: var(--color-border);
}

.access-toggle .form-check-input:checked {
    background-color: var(--color-accent);
    border-color: var(--color-accent);
}

.access-toggle .form-check-input:focus {
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
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
