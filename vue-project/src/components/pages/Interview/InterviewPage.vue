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
                <textarea v-if="!this.userAnswers[this.questionId]" v-model="answer" placeholder="Say something..." class="form-control" rows="4"></textarea>
                <textarea v-else class="form-control" disabled rows="4">{{ this.userAnswers[this.questionId] }}</textarea>
                <div class="btn-speech-container">
                    <button @click.prevent="startRecognition" type="button" class="btn btn-outline-light">Start
                        recording</button>
                    <button @click.prevent="startRecognition(false)" type="button" class="btn btn-outline-light">Add
                        record</button>
                    <button @click.prevent="sendAnswer" v-if="!this.userAnswers[this.questionId]" type="button"
                        class="btn btn-outline-light">Send answer</button>
                </div>
                <p class="mt-3" v-if="this.aiRates[this.questionId]">{{ this.aiRates[this.questionId] }}</p>
            </div>

            <div class="nav-buttons">
                <button @click="prevQuestion" class="btn-arrow">←</button>
                <button @click="nextQuestion" class="btn-arrow">→</button>
            </div>

            <div class="finish-button">
                <button @click="finishInterview" v-if="this.userAnswers.length == this.questions.length && !this.interviewFinished" class="btn btn-outline-danger">Закончить собеседование</button>
                <p v-if="this.interviewFinished" class="text-success mt-3">Собеседование завершено с рейтингом {{ this.finalRate }}/10 Ваши данные успешно отправлены создателю.</p>
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
            interviewFinished: false,
            questionId: 0,

            answer: "",
            userAnswers: [],
            aiRates: [],

            finalRate: 0,
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
                this.aiRates[this.questionId] = res.data.rate;
                this.userAnswers[this.questionId] = this.answer
                console.log(this.userAnswers);
                console.log(this.aiRates);
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

.form-control:disabled {
    background-color: #444;
    border-color: #ffffff;
    color: #fff;
    box-shadow: none;
}

.form-control::placeholder {
  color: rgb(255, 255, 255); 
  opacity: 1; 
}

.btn-speech-container {
    display: flex;
    justify-content: space-around;
}

.nav-buttons {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    gap: 20px;
}

.btn-arrow {
    background-color: #333;
    border: 1px solid #555;
    color: #fff;
    font-size: 24px;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-arrow:hover {
    background-color: #555;
}

.finish-button {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
</style>