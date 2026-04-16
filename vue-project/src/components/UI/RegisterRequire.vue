<template>
    <div class="main-container">
        <div class="main-card text-center">
            <h5 class="mb-3">Требуется авторизация</h5>
            <p class="text-secondary-2 mb-4">Для просмотра этой страницы необходимо войти в аккаунт.</p>
            <router-link to="/auth" class="btn btn-accent">
                Войти или зарегистрироваться
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
}
</script>
