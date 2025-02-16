<template>
    <div>
        <p>{{ this.answer }}</p>
        <textarea v-model="speech"></textarea>
        <div>
            <button @click.prevent="startRecognition" type="button" class="btn btn-primary">Say</button>
            <button @click.prevent="ask" type="button" class="btn btn-primary">Ask</button>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            speech: "",
            answer: "",
        };
    },

    methods: {
        startRecognition() {
            this.speech = "speak...";

            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = "ru-RU";
            recognition.start();

            recognition.onresult = (speech) => {
                this.speech = speech.results[0][0].transcript;
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
<style></style>
