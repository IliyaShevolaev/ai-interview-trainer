<template>
    <div class="page">
        <div class="main-container">
            <div v-if="this.question" class="main-card mb-3">
                <h2>{{this.question }}</h2>
                <p>{{ this.userAnswer }}</p>
                <p>{{ this.aiFeedback }}</p>

                <button v-if="!this.aiIsThinking" @click.stop="getFeedback" type="button" class="btn btn-outline-light">Ещё раз<BootstrapIcon name="restart" size="24"/></button>
            </div>
        </div>
    </div>

</template>

<script>
import BootstrapIcon from '@/components/UI/BootstrapIcon.vue';

export default {
    props: {
        id: String,
    },

    components: {
        BootstrapIcon,
    },

    data() {
        return {
            question: '',
            userAnswer: '',
            aiFeedback: '',

            aiIsThinking: false,
        }
    },

    mounted() {
        this.getFeedback();
    },

    methods: {
        getFeedback() {
            this.aiIsThinking = true;
            this.$axios.get(`/api/feedback/${this.id}`).then(res => {
                console.log(res);
                this.question = res.data.question;
                this.userAnswer = res.data.answer;
                this.aiFeedback = res.data.feedback;
                this.aiIsThinking = false;
            })
        }
    },
}
</script>
<style>
    
</style>