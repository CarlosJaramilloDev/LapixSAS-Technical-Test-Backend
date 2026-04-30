# Book Inventory API

A simple REST API to manage a book inventory, built with Laravel.

## Stack

- PHP 8.2+
- Laravel 12.x
- MariaDB
- Pest (testing)

## Installation

1. Clone the repository.
2. Install dependencies:

```bash
composer install
```

3. Copy environment variables:

```bash
cp .env.example .env
```

4. Generate the application key:

```bash
php artisan key:generate
```

5. Configure database credentials in `.env` (default setup uses MariaDB):

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lapix_tech_test
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations:

```bash
php artisan migrate
```

7. Start the local server:

```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`.

## Current Endpoints

- `GET /api/books` -> Returns all books.
- `POST /api/books` -> Creates a new book.


## Create Book Payload

Required fields:

- `title` (string, max 255)
- `description` (string)
- `price` (numeric, min 0)
- `stock` (integer, min 0)

Example:

```json
{
  "title": "El principito",
  "description": "Libro usado en las escuelas y colegios",
  "price": 12000,
  "stock": 10
}
```

## cURL Examples

### List books

```bash
curl --location --request GET 'http://127.0.0.1:8000/api/books' \
--header 'Accept: application/json'
```

### Create book

```bash
curl --location --request POST 'http://127.0.0.1:8000/api/books' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
  "title": "El principito",
  "description": "Libro usado en las escuelas y colegios",
  "price": 12000,
  "stock": 10
}'
```

## Postman Collection

A ready-to-import Postman collection is included at:

- `postman/Lapix-Books-API.postman_collection.json`

Steps:

1. Open Postman.
2. Click Import and select that file.
3. (Optional) Update the `baseUrl` variable if you use a different host/port.