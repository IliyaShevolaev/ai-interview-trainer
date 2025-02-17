<template>
    <div>
        <h1>{{ id }}</h1>
    </div>
</template>
<script>
export default {
    props: {
        id: String
    },

    mounted() {
        this.getInterviewData();
    },

    methods: {
        getInterviewData() {
            this.$axios.get(`/api/interview/get/${this.id}`).then(res => {
                console.log(res);
            })
        }
    },
}
</script>
<style>
    
</style>