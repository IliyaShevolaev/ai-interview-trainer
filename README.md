# AI Interview Trainer

AI Interview Trainer is a web application developed using Laravel and Vue.js, designed to help users practice interview skills with artificial intelligence.

## Key Features

- **Create custom interviews with questions**: Users can create their own interviews by adding questions.
- **Share interviews**: Option to share created interviews with other users.
- **Track statistics**: Monitor statistics on conducted interviews.
- **AI evaluation of candidate responses**: Artificial intelligence analyzes and evaluates candidate answers to questions.
- **Detailed AI feedback**: Provide detailed feedback on candidates' responses.
- **Search interviews**: Convenient search feature for created interviews.
- **Select AI models for assessment**: Ability to choose different AI models to evaluate interviews.
- **Authentication with Laravel Sanctum**: Secure user authentication.
- **Deployment with Docker**: The application runs in Docker containers for portability and easy deployment.

## Running the Project

To run the project, follow these steps:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/IliyaShevolaev/ai-interview-trainer.git

2. **Copy the environment file and configure the variables (enter the API key):**

   ```bash
   cp .env.example .env

3. **Run Docker Compose:**

   ```bash
   docker-compose up -d

4. **Install Laravel dependencies:**

   ```bash
   docker-compose run --rm composer install

5. **Generate the application key:**

   ```bash
   docker-compose run --rm artisan key:generate

6. **Run database migrations:**

   ```bash
   docker-compose run --rm artisan migrate

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

2. **Скопируйте файл окружения и настройте переменные(введите API ключ):**

   ```bash
   cp .env.example .env

3. **Запустите Docker Compose:**

   ```bash
   docker-compose up -d

4. **Установите зависимости Laravel:**

   ```bash
   docker-compose run --rm composer install

5. **Сгенерируйте ключ приложения:**

   ```bash
   docker-compose run --rm artisan key:generate

6. **Выполните миграции базы данных:**

   ```bash
   docker-compose run --rm artisan migrate
   
![image](https://github.com/user-attachments/assets/f3eca322-50c9-4b33-b54d-1b0dde2a9627)

![image](https://github.com/user-attachments/assets/3521bfd6-5755-4553-84d8-11d01a9c7a2a)

![image](https://github.com/user-attachments/assets/176c7f9c-1305-4d1b-af8f-38fa4533f801)

![image](https://github.com/user-attachments/assets/a71605c9-3e2d-4eae-a205-faaed21b5205)

![image](https://github.com/user-attachments/assets/4b41b7d6-ad5a-4e9e-80a3-536ee79fd765)

![image](https://github.com/user-attachments/assets/2133fe96-dbb3-45cd-b0b3-6a7d2f4d2fae)
