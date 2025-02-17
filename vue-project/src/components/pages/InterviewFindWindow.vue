<template>
    <div>
        <h1>{{ this.token }}</h1>
    </div>
</template>
<script>
export default {
    props: {
        token: String
    },

    data() {
        return {

        }
    },

    mounted() {
        this.getInterviewDataByToken(this.token);
    },

    methods: {
        getInterviewData(id) {
            this.$axios.get(`/api/interview/get/${id}`).then(res => {
                console.log(res);
            })
        },

        getInterviewDataByToken(token) {
            this.$axios.get(`/api/retokenaize-token/${token}`).then(res => {
                this.getInterviewData(res.data.id);
            }).catch(error => {
                console.log(error);
            });
        },
    },
}
</script>
<style>
    
</style>