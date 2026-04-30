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
- `GET /api/books/{book}` -> Returns a single book by ID.
- `PUT /api/books/{book}` -> Updates a book by ID.
- `DELETE /api/books/{book}` -> Deletes a book by ID.
- `POST /api/books/{book}/stock` -> Updates stock using transaction + pessimistic locking.


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

### Get book by ID

```bash
curl --location --request GET 'http://127.0.0.1:8000/api/books/1' \
--header 'Accept: application/json'
```

### Update book

```bash
curl --location --request PUT 'http://127.0.0.1:8000/api/books/1' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
  "title": "El principito - Edicion actualizada",
  "description": "Libro usado en las escuelas y colegios",
  "price": 15000,
  "stock": 12
}'
```

### Delete book

```bash
curl --location --request DELETE 'http://127.0.0.1:8000/api/books/1' \
--header 'Accept: application/json'
```

### Update stock

Payload:

```json
{
  "amount": -2
}
```

Notes:

- Use a positive `amount` to add stock.
- Use a negative `amount` to remove stock.
- If resulting stock is negative, the API returns `422`.

```bash
curl --location --request POST 'http://127.0.0.1:8000/api/books/1/stock' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
  "amount": -2
}'
```

## Postman Collection

A ready-to-import Postman collection is included at:

- `postman/Lapix-Books-API.postman_collection.json`

Steps:

1. Open Postman.
2. Click Import and select that file.
3. (Optional) Update the `baseUrl` variable if you use a different host/port.