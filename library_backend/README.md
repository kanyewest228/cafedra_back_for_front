# Backend: Платформа для совместного написания сценариев и книг

REST API бэкенд на **Laravel 13** для фронтенд-спринта (`52sprint.md`).

## Стек технологий

* **PHP 8.4**
* **Laravel 13**
* **PostgreSQL 16**
* **pgAdmin 4**
* **Nginx** (в Docker)
* **Docker & Docker Compose**

---

## Архитектура и принципы SOLID

Проект спроектирован с разделением ответственности и соблюдением стандартов Laravel:

1. **Form Requests (`app/Http/Requests`)**:
   - `BookIndexRequest` — валидация параметров пагинации (`page`, `per_page`) и поиска (`search`).
   - `StoreBookRequest` / `UpdateBookRequest` — валидация полей книги (`title`, `author`, `description`, `full_text`).
   - `CommentIndexRequest` — валидация фильтра по категориям (`category`).
   - `StoreCommentRequest` — строгая валидация категорий через Enum и проверка принадлежности `parent_id` текущей книге.

2. **Actions (`app/Actions`)**:
   - `GetBooksAction` — получение списка книг с пагинацией (по умолчанию **8 книг** по ТЗ) и поиском.
   - `GetBookAction` — получение сущности книги.
   - `CreateBookAction` / `UpdateBookAction` / `DeleteBookAction` — CRUD операции над книгами.
   - `GetBookCommentsTreeAction` — формирование вложенного дерева комментариев (`children`) в один SQL-запрос $O(N)$ без проблемы $N+1$, с поддержкой фильтрации корневых веток по категориям.
   - `CreateCommentAction` — создание комментария / ответа с проверкой целостности дерева.
   - `DeleteCommentAction` — каскадное удаление комментария и его дочерних веток.

3. **API Resources (`app/Http/Resources`)**:
   - `BookResource` — трансформация модели `Book` в контракт API с форматированием дат ISO 8601.
   - `CommentResource` — трансформация модели `Comment` с рекурсивной сериализацией вложенных `children: []`.

4. **Enums (`app/Enums`)**:
   - `CommentCategory` — строгая типизация категорий: `alternative`, `edit`, `lore`, `question`.

---

## Быстрый старт с Docker

### 1. Подготовка конфигурации окружения (.env)

```bash
cp .env.example .env
```

### 2. Запуск контейнеров

```bash
docker compose up -d --build
```

Будут запущены 4 сервиса:
- **Nginx (API)**: [http://localhost:8000](http://localhost:8000)
- **PostgreSQL**: `localhost:5432` (БД: `library_db`, пользователь: `library_user`, пароль: `library_password`)
- **pgAdmin**: [http://localhost:5050](http://localhost:5050) (Email: `admin@example.com`, Пароль: `admin`)
- **PHP 8.4-FPM**: внутренний сервис `app`

### 3. Применение миграций и наполнение сидерами

```bash
docker compose exec app php artisan migrate --seed
```

---

## Локальный запуск (без Docker)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve --port=8000
```

---

## Запуск тестов

```bash
php artisan test
```

---

## Postman Коллекция

В папке проекта сохранен файл [`postman_collection.json`](file:///home/selfmade/Projects/back_for_front/library_backend/postman_collection.json) (формат Postman v2.1.0).

Для импорта:
1. В Postman нажмите кнопку **Import**;
2. Выберите файл `postman_collection.json`;
3. Коллекция готова к работе с переменной `{{baseUrl}}` (`http://localhost:8000`).
