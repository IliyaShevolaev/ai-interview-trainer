<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <form @submit.prevent="create">
                    <div class="mb-3">
                        <label for="title" class="form-label">Name</label>
                        <input v-model="name" type="text" class="form-control" id="title" placeholder="Enter name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Questions</label>
                        <div v-for="(question, index) in questions" :key="index" class="d-flex mb-2">
                            <input v-model="questions[index]" type="text" class="form-control"
                                :placeholder="`Question ${index + 1}`">
                            <button type="button" class="btn btn-outline-danger ms-2" @click="removeQuestion(index)"
                                v-if="questions.length > 1">&times;</button>
                        </div>
                        <button type="button" class="btn btn-outline-success" @click="addQuestion">+</button>
                    </div>

                    <button type="submit" class="btn btn-outline-primary">Create</button>
                </form>
            </div>

            <div v-if="interviewToken" class="link-card">
                <p>Your interview link:</p>
                <div class="link-container">
                    <input type="text" :value="fullInterviewLink" class="form-control" readonly>
                    <button @click="copyLink" class="btn btn-secondary"><BootstrapIcon name="copy" size="24"/></button>
                </div>
                <p v-if="copySuccess" class="copy-success">Link copied!</p>
            </div>
        </div>
    </div>
</template>

<script>
import BootstrapIcon from '@/components/UI/BootstrapIcon.vue';

export default {
    components: {
        BootstrapIcon
    },

    data() {
        return {
            name: '',
            questions: [''],
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
        addQuestion() {
            this.questions.push('');
        },
        removeQuestion(index) {
            this.questions.splice(index, 1);
        },
        create() {
            let formData = new FormData();
            formData.append("title", this.name);

            this.questions.forEach((question, index) => {
                if (question !== '') {
                    formData.append(`questions[${index}]`, question);
                }
            });

            this.$axios.post("/api/interview/store", formData).then(res => {
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
.link-card {
    margin-top: 20px;
    background-color: #2c2c2c;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.link-card p {
    margin: 0 0 10px;
    font-size: 16px;
    color: #e0e0e0;
}

.link-container {
    display: flex;
    gap: 10px;
}

.link-container input {
    flex-grow: 1;
    background-color: #3a3a3a;
    color: #fff;
    border: none;
    padding: 8px;
    border-radius: 5px;
}
</style>
