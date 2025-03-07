<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# AI Interview Trainer

AI Interview Trainer — это веб-приложение, разработанное с использованием Laravel и Vue.js, предназначенное для тренировки прохождения собеседований с помощью искусственного интеллекта.

## Основные возможности

- **Создание собеседований с вопросами**: пользователи могут создавать собственные собеседования, добавляя к ним вопросы.
- **Совместное использование собеседований**: возможность делиться созданными собеседованиями с другими пользователями.
- **Отслеживание статистики**: мониторинг статистики по проведенным собеседованиям.
- **Оценка ответов кандидатов ИИ**: искусственный интеллект анализирует и оценивает ответы кандидатов на вопросы.
- **Детальный ИИ-фидбэк**: предоставление подробной обратной связи на ответы кандидатов.
- **Поиск по собеседованиям**: удобный поиск по созданным собеседованиям.
- **Выбор ИИ-моделей для проверки**: возможность выбора различных моделей ИИ для оценки собеседований.
- **Аутентификация с помощью Laravel Sanctum**: безопасная аутентификация пользователей.
- **Развертывание в Docker**: приложение работает в контейнерах Docker для обеспечения портативности и простоты развертывания.

## Запуск проекта

Для запуска проекта выполните следующие шаги:

1. **Клонируйте репозиторий:**

   ```bash
   git clone https://github.com/IliyaShevolaev/ai-interview-trainer.git

2. **Скопируйте файл окружения и настройте переменные:**

   ```bash
   cp .env.example .env

3. **Запустите Docker Compose:**

   ```bash
   docker-compose up -d

4. **Установите зависимости Laravel:**

   ```bash
   composer install

5. **Установите зависимости Laravel:**

   ```bash
   composer install

6. **Сгенерируйте ключ приложения:**

   ```bash
   php artisan key:generate

7. **Выполните миграции базы данных:**

   ```bash
   php artisan migrate
