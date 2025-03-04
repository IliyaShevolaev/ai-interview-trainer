<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <h2 class="mb-4">Edit interview</h2>
                <form @submit.prevent="edit">
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

                    <button type="submit" class="btn btn-outline-primary">Edit</button>
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
export default {
    props: {
        token: String,
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
                    console.log(res);
                    this.interviewId = res.data.id,
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
