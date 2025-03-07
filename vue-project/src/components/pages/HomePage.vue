<template>
    <div class="min-vh-100 custom-bg text-white d-flex flex-column align-items-center p-4 position-relative">
        <header class="d-flex justify-content-between align-items-center py-3">
            <h1 class="fs-3 fw-bold">AI Interview Trainer</h1>
        </header>

        <main class="d-flex flex-column align-items-center text-center mt-5">
            <h2 class="fs-4 fw-semibold mb-3">Готовьтесь к интервью с ИИ ассистентом</h2>
            <p class="text-secondary w-75">
                Улучшите свои навыки прохождения интервью, тренируясь с нашим умным ассистентом на основе искусственного
                интеллекта.
            </p>

            <button @click.prevent="start" class="btn btn-outline-success mt-4 px-4 py-2 fs-5">
                Начать тренировку
            </button>
        </main>

        <section class="mt-5 w-75">
            <h3 class="fs-5 fw-medium mb-3">Почему стоит попробовать?</h3>
            <ul class="list-unstyled text-secondary">
                <li>🔹 Реалистичные сценарии интервью</li>
                <li>🔹 Персонализированные рекомендации</li>
                <li>🔹 Анализ ваших ответов</li>
                <li>🔹 Гибкость и удобство</li>
            </ul>
        </section>

        <footer class="text-secondary text-small position-absolute w-100 text-center bottom-0 py-2">
            &copy; 2025 AI Interview Trainer. Все права защищены.
        </footer>

    </div>
</template>

<script>
export default {
    methods: {
        start() {
            this.$router.push({ name: 'find' });
        }
    },
};
</script>

<style scoped>
.custom-bg {
    background-color: #1a1a2e;
}

.max-w-800 {
    max-width: 800px;
}

.text-small {
    font-size: 0.875rem;
}
</style>
