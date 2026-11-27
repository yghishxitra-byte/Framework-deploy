\# 🚀 Framework Practice: Auto Parts Catalog



Учебный пет-проект для практического сравнения популярных бэкенд-фреймворков (\*\*Laravel\*\*, \*\*FastAPI\*\*, \*\*NestJS\*\*) на базе единой инфраструктуры и общей схемы данных.



Предметная область — \*\*каталог автозапчастей\*\* с поддержкой поиска по названию, фильтрации по категориям, привязкой товаров к складам, кэшированием запросов в Redis и отображением времени выполнения запроса.



\---



\## 🛠 Технологический стек



\* \*\*Инфраструктура:\*\* Docker, Docker Compose

\* \*\*Веб-сервер:\*\* Nginx (Alpine)

\* \*\*База данных:\*\* PostgreSQL 16 (Alpine)

\* \*\*Миграции БД:\*\* Atlas (декларативная схема в формате HCL)

\* \*\*Кэширование:\*\* Redis 7 (Alpine)

\* \*\*Реализации бэкенда:\*\*

&#x20; \* ✅ \*\*PHP 8.4 + Laravel\*\* (`php-fpm`, `phpredis`, `pdo\_pgsql`) — \*реализовано\*

&#x20; \* ⏳ \*\*Python + FastAPI\*\* — \*в планах\*

&#x20; \* ⏳ \*\*Node.js + NestJS\*\* — \*в планах\*



\---



\## 📂 Структура репозитория



```text

framework-practice/

├── 01-docker/          # Docker Compose и кастомные Dockerfile

├── 02-database/        # Декларативная схема БД для Atlas (schema.hcl)

├── 03-nginx/           # Конфигурация виртуальных хостов Nginx (default.conf)

├── 04-redis/           # Конфигурация и данные для Redis

├── laravel/            # Реализация приложения на Laravel (активна)

├── fastapi/            # Реализация на FastAPI (в разработке)

└── nestjs/             # Реализация на NestJS (в разработке)

```



\---



\## 🗄 Архитектура базы данных



Схема базы данных описана декларативно в `02-database/schema.hcl` и накатывается с помощью \*\*Atlas\*\*:



\* \*\*`categories`\*\* — категории автозапчастей (`id`, `name`, уникальный индекс по `slug`).

\* \*\*`warehouses`\*\* — склады хранения (`id`, `name`).

\* \*\*`products`\*\* — карточки товаров (`id`, `category\_id`, `warehouse\_id`, `name`, `slug`, `description`, `price`, `stock\_quantity`, `created\_at`, `updated\_at`) с внешними ключами и индексами по `slug`, `category\_id` и `price`.



\---



\## 🚀 Быстрый запуск (Laravel + Docker)



\### 1. Клонирование репозитория

```bash

git clone <URL\_вашего\_репозитория>

cd framework-practice

```



\### 2. Настройка окружения Laravel

Скопируйте файл конфигурации окружения (если `.env` еще не создан) и убедитесь, что параметры подключения совпадают с `01-docker/docker-compose.yml`:

```bash

cp laravel/.env.example laravel/.env

```



Основные параметры подключения в `laravel/.env`:

```env

DB\_CONNECTION=pgsql

DB\_HOST=postgres

DB\_PORT=5432

DB\_DATABASE=practice\_db

DB\_USERNAME=app\_user

DB\_PASSWORD=secret\_password



REDIS\_HOST=redis

REDIS\_PASSWORD=secret\_redis\_password

REDIS\_PORT=6379

CACHE\_STORE=redis

```



\### 3. Сборка и запуск контейнеров

Перейдите в директорию с конфигурацией Docker и поднимите сервисы:

```bash

cd 01-docker

docker compose up -d --build

```



Будут запущены 4 контейнера:

\* `framework\_practice\_db` — PostgreSQL 16 (порт `5432`)

\* `framework\_practice\_redis` — Redis 7 (порт `6379`)

\* `framework\_practice\_php` — PHP 8.4 FPM с приложением Laravel

\* `framework\_practice\_nginx` — Nginx (порт `8080`)



\### 4. Применение схемы БД (Atlas)

Накатите схему из `02-database/schema.hcl` на запущенный контейнер PostgreSQL:

```bash

atlas schema apply \\

&#x20; --url "postgres://app\_user:secret\_password@localhost:5432/practice\_db?sslmode=disable" \\

&#x20; --to "file://../02-database/schema.hcl"

```



\### 5. Инициализация Laravel и загрузка тестовых данных

Установите зависимости (если папка `vendor` не смонтирована), сгенерируйте ключ и очистите кэш:

```bash

docker compose exec laravel\_app composer install

docker compose exec laravel\_app php artisan key:generate

docker compose exec laravel\_app php artisan optimize:clear

\# Если настроены сидеры для генерации товаров, категорий и складов:

docker compose exec laravel\_app php artisan db:seed

```



\### 6. Проверка работы

Откройте в браузере: \*\*\[http://localhost:8080](http://localhost:8080)\*\*



\---



\## ✨ Реализованный функционал



\* \*\*Каталог товаров:\*\* отображение карточек запчастей с ценой, складом, остатком и описанием.

\* \*\*Поиск и фильтрация:\*\* живой поиск по названию запчасти и фильтрация по категориям.

\* \*\*Кэширование в Redis:\*\* результаты выборок кэшируются в Redis, а в интерфейсе отображается актуальное время выполнения запроса (в миллисекундах) и статус использования кэша.

\* \*\*Изолированная инфраструктура:\*\* все компоненты работают в единой Docker-сети с сохранением данных БД и Redis в Docker Volumes.



