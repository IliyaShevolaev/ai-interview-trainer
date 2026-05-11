<template>
    <div class="page home-page">
        <section class="hero">
            <div class="container text-center">
                <h1 class="hero-title">Готовьтесь к интервью с ИИ ассистентом</h1>
                <p class="hero-subtitle text-secondary-2">
                    Улучшите свои навыки прохождения интервью, тренируясь с умным ассистентом
                    на основе искусственного интеллекта.
                </p>
                <button @click.prevent="start" class="btn btn-accent btn-lg mt-2">
                    Начать тренировку
                </button>
            </div>
        </section>

        <section class="features container">
            <h2 class="section-title text-center mb-5">Почему стоит попробовать?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card p-4 h-100">
                        <h5 class="mb-2">Реалистичные сценарии</h5>
                        <p class="text-secondary-2 mb-0">Собеседования, приближённые к настоящим собеседованиям.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card p-4 h-100">
                        <h5 class="mb-2">Персональные рекомендации</h5>
                        <p class="text-secondary-2 mb-0">ИИ даёт развёрнутую обратную связь по каждому ответу.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card p-4 h-100">
                        <h5 class="mb-2">Анализ ответов</h5>
                        <p class="text-secondary-2 mb-0">Понятная оценка и разбор сильных и слабых сторон.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card p-4 h-100">
                        <h5 class="mb-2">Гибкость и удобство</h5>
                        <p class="text-secondary-2 mb-0">Тренируйтесь в любое время и в комфортном для вас темпе.</p>
                    </div>
                </div>
            </div>
        </section>
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
.home-page {
    min-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
}

.hero {
    padding: var(--space-16) var(--space-4) var(--space-12);
    display: flex;
    justify-content: center;
}

.hero-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: var(--space-4);
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.hero-subtitle {
    font-size: 1.125rem;
    max-width: 600px;
    margin: 0 auto var(--space-8);
    line-height: 1.6;
}

.features {
    padding: var(--space-12) var(--space-4);
    flex-grow: 1;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--color-text);
}

.home-footer {
    padding: var(--space-6) var(--space-4);
    font-size: 0.875rem;
    border-top: 1px solid var(--color-border);
    margin-top: auto;
}
</style>
