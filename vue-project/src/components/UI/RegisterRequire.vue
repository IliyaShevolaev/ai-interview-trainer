<template>
    <div class="main-container">
        <div class="main-card mb-3">
            <p>Необходима
                <router-link to="/auth" type="button" class="btn btn-outline-light">
                    регистрация
                </router-link>, для просмотра результатов
            </p>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        handleClick(id) {
            this.$router.push({ name: 'profile.rate', params: { id: id } });
        },
    },
}
</script>

<style></style>