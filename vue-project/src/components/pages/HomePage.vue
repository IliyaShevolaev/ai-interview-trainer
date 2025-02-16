<template>
    <div class="page">
        <div class="container">
            <div class="card">
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
.page {
    background-color: #121212;
    color: #ffffff;
    font-family: 'Arial', sans-serif;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    flex-direction: column;
}

.card {
    background-color: #1f1f1f;
    border: none;
    padding: 30px;
    border-radius: 10px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.card p {
    font-size: 18px;
    color: #e0e0e0;
}

.form-control {
    background-color: #333;
    border: 1px solid #444;
    color: #fff;
    margin-bottom: 15px;
    border-radius: 5px;
}

.form-control:focus {
    background-color: #444;
    border-color: #007bff;
    color: #fff;
    box-shadow: none;
}

.btn-container {
    display: flex;
    justify-content: space-around;
}
</style>
