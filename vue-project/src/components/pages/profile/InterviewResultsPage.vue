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
        this.$axios.get(`/api/retokenaize-token/${this.token}`).then(res => {
            console.log(res.data.id)
            this.$axios.get(`/api/profile/interviews-manage/results/${res.data.id}`).then(responce => {
                console.log(responce);
            })
        });
    },
}
</script>

<style>
    
</style>