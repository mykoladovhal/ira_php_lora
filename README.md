# EventEase - イベント管理システム

EventEase — система управления мероприятиями на Laravel 12 с японским интерфейсом.

## Функционал

- Регистрация и авторизация пользователей
- Создание, редактирование и удаление событий
- Поиск и фильтрация событий по категориям
- Участие в событиях (регистрация/отмена)
- Календарь событий (FullCalendar)
- Панель администратора для управления пользователями
- Японский интерфейс (日本語)

## Категории событий

- 博覧会 (Выставки)
- 見本市・展示会 (Ярмарки)
- 会議イベント (Конференции)
- 文化イベント (Культурные)
- スポーツイベント (Спортивные)
- 販促イベント (Промо-акции)
- その他 (Другое)

## Требования

- Docker
- Docker Compose
- Git

## Установка

```bash
# 1. Клонировать репозиторий
git clone https://github.com/mykoladovhal/ira_php_lora.git
cd ira_php_lora

# 2. Скопировать файл окружения
cp .env.example .env

# 3. Запустить Docker контейнеры
docker-compose up -d

# 4. Установить PHP зависимости
docker exec ira_php_lara_app composer install

# 5. Сгенерировать ключ приложения
docker exec ira_php_lara_app php artisan key:generate

# 6. Установить npm зависимости
docker exec ira_php_lara_app npm install

# 7. Собрать фронтенд
docker exec ira_php_lara_app npm run build

# 8. Запустить миграции и сидеры
docker exec ira_php_lara_app php artisan migrate --seed
```

## Запуск

После установки приложение доступно по адресу: **http://localhost:8080**

## Тестовые аккаунты

| Роль | Email | Пароль |
|------|-------|--------|
| Админ | admin@example.com | password |
| Пользователь | test@example.com | password |

## Полезные команды

```bash
# Запустить контейнеры
docker-compose up -d

# Остановить контейнеры
docker-compose down

# Посмотреть логи
docker-compose logs -f

# Выполнить artisan команду
docker exec ira_php_lara_app php artisan <command>

# Пересобрать фронтенд (production)
docker exec ira_php_lara_app npm run build

# Режим разработки фронтенда
docker exec ira_php_lara_app npm run dev

# Сбросить базу данных
docker exec ira_php_lara_app php artisan migrate:fresh --seed
```

## Технологии

- **Backend:** Laravel 12, PHP 8.x
- **Frontend:** Tailwind CSS, Alpine.js, Vite
- **Calendar:** FullCalendar
- **Database:** MySQL 8.0
- **Auth:** Laravel Breeze

## Структура проекта

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   └── UserController.php
│   │   ├── CalendarController.php
│   │   ├── DashboardController.php
│   │   ├── EventController.php
│   │   └── ParticipantController.php
│   └── Middleware/
│       └── AdminMiddleware.php
└── Models/
    ├── Category.php
    ├── Event.php
    └── User.php

resources/views/
├── admin/users/
├── calendar/
├── components/
├── events/
├── layouts/
└── dashboard.blade.php
```

## Лицензия

MIT
