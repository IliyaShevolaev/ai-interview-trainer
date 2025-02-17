<template>
    <div class="page">
        <div v-if="!this.inProcess" class="main-container">
            <div class="main-card">
                <div v-if="questions" class="btn-container">
                    <h2 class="mb-3">{{ this.title }}</h2>
                    <p>Contains {{ this.questions.length }} questions. Are you ready to start?</p>
                    <button @click.prevent="startInterview" type="button" class="btn btn-outline-light">Start</button>
                </div>
            </div>
        </div>

        <div v-else class="main-container">
            <div class="main-card">
                <p>{{ this.questions[this.questionId]['text'] }}</p>
                <textarea v-model="answer" class="form-control" rows="4"></textarea>
                <div class="btn-speech-container">
                    <button @click.prevent="startRecognition" type="button" class="btn btn-outline-light">Start recording</button>
                    <button @click.prevent="startRecognition(false)" type="button" class="btn btn-outline-light">Add record</button>
                    <button @click.prevent="sendAnswer" type="button" class="btn btn-outline-light">Send answer</button>
                </div>
                <p class="mt-3" v-if="aiRate">{{ this.aiRate }}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        token: String
    },

    data() {
        return {
            interviewId: null,
            title: null,
            questions: null,

            inProcess: false,
            questionId: 0,

            answer: "Say something",
            aiRate: null,
        }
    },

    mounted() {
        this.getInterviewDataByToken(this.token);
    },

    methods: {
        getInterviewData(id) {
            this.$axios.get(`/api/interview/get/${id}`).then(res => {
                console.log(res);
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
            this.$axios.post('/api/interview/rate-answer', {
                interviewTitle: this.title,
                question: this.questions[this.questionId]['text'],
                answer: this.answer,
            }).then(res => {
                this.aiRate = res.data.rate;
                console.log(res);
            });
        },
    },
}
</script>
<style scoped>
.form-control {
    background-color: #333;
    border: 1px solid #444;
    color: #fff;
    margin-bottom: 15px;
    border-radius: 5px;
}

.form-control:focus {
    background-color: #444;
    border-color: #ffffff;
    color: #fff;
    box-shadow: none;
}

.btn-speech-container {
    display: flex;
    justify-content: space-around;
}
</style>