<template>
    <div class="page">
        <div class="main-container">
            <div class="main-card">
                <p>{{ this.answer }}</p>
                <textarea v-model="speech" class="form-control" rows="4"></textarea>
                <div class="btn-container">
                    <button @click.prevent="startRecognition" type="button" class="btn btn-outline-light">Start recording</button>
                    <button @click.prevent="startRecognition(false)" type="button" class="btn btn-outline-light">Add record</button>
                    <button @click.prevent="ask" type="button" class="btn btn-outline-light">Ask</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            speech: "Say something",
            answer: "",
        };
    },

    methods: {
        startRecognition(isStart = true) {
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = "ru-RU";
            recognition.start();

            recognition.onresult = (speech) => {
                isStart ? this.speech = speech.results[0][0].transcript : this.speech += ' ' + speech.results[0][0].transcript
                recognition.stop();
            };

            recognition.onerror = (event) => {
                console.error(event.error);
            };
        },

        ask() {
            this.$axios.post('/api/ask', {
                prompt: this.speech,
            }).then(res => {
                this.answer = res.data.answer;
            });
        },
    },
};
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

.btn-container {
    display: flex;
    justify-content: space-around;
}
</style>
