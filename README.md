# Backend: Платформа для совместного написания сценариев и книг

## Запуск


### 1. 

```bash
cd library_backend
cp .env.example .env
```

### 2. Докер

```bash
docker compose up -d --build
```

- **Nginx (API)**: [http://localhost:8000](http://localhost:8000)
- **PostgreSQL**: `localhost:5432` (БД: `library_db`, пользователь: `library_user`, пароль: `library_password`)
- **pgAdmin**: [http://localhost:5050](http://localhost:5050) (Email: `admin@example.com`, Пароль: `admin`)

### 3. Миграции + сидеры

```bash
docker compose exec app php artisan migrate --seed
```

Сидеры создадут:
- 18 книг с реалистичными названиями и текстами (для удобного тестирования пагинации по 8 книг и infinite scroll);
- Точные сущности из ТЗ (`Тени забытого мира`, `Призрак каштака`);
- Вложенное дерево комментариев с точными ID (101, 102, 103 и т.д.) по разделам `lore`, `alternative`, `edit`, `question`.

---


## Спецификация API Endpoints

### 1. Список книг (Главная страница)

```http
GET /api/books
```

**Query параметры:**
* `page` (int, default: 1) — номер страницы
* `per_page` (int, default: 8) — количество книг на странице (**по умолчанию 8** по ТЗ)
* `search` (string, optional) — поиск по названию/автору

**Пример ответа (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Тени забытого мира",
      "author": "Иван Иванов",
      "description": "Краткое описание сюжета...",
      "full_text": "Полный текст книги...",
      "created_at": "2026-10-01T12:00:00.000000Z",
      "updated_at": "2026-10-01T12:00:00.000000Z"
    },
    {
      "id": 2,
      "title": "Призрак каштака",
      "author": "Олег Бачаров",
      "description": "Краткое описание сюжета...",
      "full_text": "Полный текст книги...",
      "created_at": "2026-10-01T12:00:00.000000Z",
      "updated_at": "2026-10-01T12:00:00.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/books?page=1",
    "last": "http://localhost:8000/api/books?page=3",
    "prev": null,
    "next": "http://localhost:8000/api/books?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 3,
    "per_page": 8,
    "to": 8,
    "total": 18
  }
}
```

---

### 2. Детальная информация о книге

```http
GET /api/books/{id}
```

**Пример ответа (200 OK):**
```json
{
  "id": 1,
  "title": "Тени забытого мира",
  "author": "Иван Иванов",
  "description": "Краткое описание сюжета: в мире, где солнце исчезло...",
  "full_text": "Глава 1. Пробуждение во тьме...",
  "created_at": "2026-10-01T12:00:00.000000Z",
  "updated_at": "2026-10-01T12:00:00.000000Z"
}
```

---

### 3. Дерево комментариев книги

```http
GET /api/books/{id}/comments
```

**Query параметры:**
* `category` (string, optional: `alternative`, `edit`, `lore`, `question`) — фильтрация веток по разделу.

**Пример ответа (200 OK):**
```json
[
  {
    "id": 101,
    "book_id": 1,
    "parent_id": null,
    "category": "lore",
    "author": "Мария П.",
    "text": "А кто такой Главный Герой в первой главе?",
    "created_at": "2026-10-02T15:30:00.000000Z",
    "children": [
      {
        "id": 102,
        "book_id": 1,
        "parent_id": 101,
        "category": "lore",
        "author": "Иван И.",
        "text": "Это потомок древнего рода...",
        "created_at": "2026-10-02T16:00:00.000000Z",
        "children": []
      }
    ]
  },
  {
    "id": 103,
    "book_id": 1,
    "parent_id": null,
    "category": "alternative",
    "author": "Петр С.",
    "text": "А что если в конце он не уедет?",
    "created_at": "2026-10-03T10:00:00.000000Z",
    "children": []
  }
]
```

---

### 4. Добавить комментарий или ответ

```http
POST /api/books/{id}/comments
```

**Body (JSON):**
```json
{
  "parent_id": 101,
  "category": "lore",
  "author": "Читатель 1",
  "text": "Полностью согласен с этой теорией!"
}
```
*Для создания корневого комментария передайте `"parent_id": null` или опустите его.*

**Ответ (201 Created):**
```json
{
  "id": 110,
  "book_id": 1,
  "parent_id": 101,
  "category": "lore",
  "author": "Читатель 1",
  "text": "Полностью согласен с этой теорией!",
  "created_at": "2026-10-08T07:30:00.000000Z",
  "children": []
}
```

---

### 5. Создание книги

```http
POST /api/books
```

**Body (JSON):**
```json
{
  "title": "Хроники пустоты",
  "author": "Имя Автора",
  "description": "Краткое описание",
  "full_text": "Полный текст книги..."
}
```

---

### 6. Удаление комментария

```http
DELETE /api/comments/{id}
```
*Удаляет комментарий и каскадно все дочерние ответы.*
**Ответ:** 204 No Content.

---

## Подключение pgAdmin

- URL: [http://localhost:5050](http://localhost:5050)
- Email: `admin@example.com`
- Пароль: `admin`
- Сервер базы данных **Library PostgreSQL** уже предварительно настроен в `servers.json`. При входе введите пароль пользователя БД `library_password`.


