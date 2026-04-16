<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <h4 class="mb-4">Редактировать собеседование</h4>

                <form @submit.prevent="edit">
                    <div class="mb-4">
                        <label for="title" class="form-label">Название</label>
                        <input v-model="name" type="text" class="form-control" id="title"
                            placeholder="Введите название" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Вопросы</label>
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

                    <button type="submit" class="btn btn-accent w-100">Сохранить</button>
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
</style>
