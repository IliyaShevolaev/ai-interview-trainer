<template>
    <div>
        <p>name: {{ this.user.name }}</p>
        <p>email: {{ this.user.email }}</p>
    </div>
</template>
<script>
export default {
    data() {
        return {
            user: {
                name: null,
                email: null
            }
        }
    },

    mounted() {
        this.$axios.get('/api/user').then(res => {
            console.log(res);
            this.user.name = res.data.name;
            this.user.email = res.data.email;
        })
    },
}
</script>
<style>
    
</style>