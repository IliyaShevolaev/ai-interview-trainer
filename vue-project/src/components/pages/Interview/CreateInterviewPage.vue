<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <h4 class="mb-4">Создать собеседование</h4>

                <form @submit.prevent="create">
                    <div class="mb-4">
                        <label for="title" class="form-label">Название</label>
                        <input v-model="name" type="text" class="form-control" id="title"
                            placeholder="Введите название" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Список вопросов</label>
                        <div v-for="(question, index) in questions" :key="index" class="d-flex gap-2 mb-2">
                            <input v-model="questions[index]" type="text" class="form-control"
                                :placeholder="`Вопрос ${index + 1}`">
                            <button type="button" class="btn btn-ghost btn-remove"
                                @click="removeQuestion(index)" v-if="questions.length > 1">
                                &times;
                            </button>
                        </div>
                        <button type="button" class="btn btn-ghost mt-2" @click="addQuestion">
                            + Добавить вопрос
                        </button>
                    </div>

                    <div class="access-toggle mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="publicSwitch" v-model="isPublic">
                            <label class="form-check-label text-secondary-2" for="publicSwitch">
                                Доступ: {{ isPublic ? 'Общедоступный' : 'Только по ссылке' }}
                            </label>
                        </div>
                    </div>

                    <button v-if="authCheck()" type="submit" class="btn btn-accent w-100">
                        Создать
                    </button>
                    <div v-else class="text-center text-secondary-2">
                        <p class="mb-2">Необходима регистрация для создания собеседования.</p>
                        <router-link to="/auth" class="btn btn-accent">Войти</router-link>
                    </div>
                </form>
            </div>

            <div v-if="interviewToken" class="main-card mt-3">
                <p class="text-secondary-2 mb-2">Ссылка на собеседование</p>
                <div class="d-flex gap-2">
                    <input type="text" :value="fullInterviewLink" class="form-control" readonly>
                    <button @click="copyLink" class="btn btn-ghost btn-copy">
                        <BootstrapIcon name="copy" size="18" />
                    </button>
                </div>
                <p v-if="copySuccess" class="text-accent-soft small mt-2 mb-0">Ссылка скопирована!</p>
            </div>
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
            copySuccess: false
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

        create() {
            let questionsList = [];
            this.questions.forEach((question) => {
                if (question !== '') {
                    questionsList.push(question);
                }
            });

            this.$axios.post("/api/interview/store", {
                'title': this.name,
                'questions': questionsList,
                'isPublic': this.isPublic,
            }).then(res => {
                console.log(res);
                this.interviewToken = res.data.token;
            });
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
.btn-remove {
    padding: 0.5rem 0.85rem;
    color: var(--color-text-muted);
}

.btn-remove:hover {
    color: var(--color-error);
    border-color: var(--color-error);
}

.btn-copy {
    padding: 0.5rem 0.85rem;
    color: var(--color-text-2);
}

.access-toggle .form-check-input:checked {
    background-color: var(--color-accent);
    border-color: var(--color-accent);
}
</style>
