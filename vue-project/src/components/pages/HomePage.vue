<template>
    <div>
        <h1>Hello</h1>
        <p>{{ this.speech }}</p>
        <textarea v-model="speech"></textarea>
        <button @click.prevent="startRecognition" type="button" class="btn btn-primary">Say</button>
        <button @click.prevent="userTest" type="button" class="btn btn-primary">User</button>

    </div>
</template>
<script>
export default {
    data() {
        return {
            speech: "",
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

        userTest() {
            this.$axios.get('/api/user').then(res => {
                    console.log(res);
                });
        },
    },
};
</script>
<style></style>
