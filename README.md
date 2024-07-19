![Laravel Logo](https://laravel.com/img/logomark.min.svg)

# Laravel Products API

## Description

The Laravel Products API is a RESTful web service designed to manage product data. It allows for the creation, retrieval, updating, and deletion of product information in a database, making it an ideal backend for e-commerce applications.

## Built With

**Laravel v11.16.0** and **PHP v8.3.9**

## Installation

Clone the repository to your local machine:

```bash
git clone https://github.com/yourusername/laravel-products-api.git
cd laravel-products-api
```

Install the dependencies:

```bash
composer install
```

Set up your environment variables:

```bash
cp .env.example .env
```
Open the .env file and configure your database connection. You can specify either MySQL or SQLite. For MySQL, set the following:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
````

For SQLite, set the following:
```bash
DB_CONNECTION=sqlite
DB_DATABASE=/path_to_your_database/database.sqlite
```

After configuring the database, generate an application key:
```bash
php artisan key:generate
```

Run the migrations:

```bash
php artisan migrate
```

Start the server:

```bash
php artisan serve
```

## Usage

To retrieve a list of products, send a GET request to `/api/products`.

Example request:

```bash
curl http://localhost:8000/api/products
```

Example response:

```json
[
  {
    "id": 1,
    "name": "Product 1",
    "description": "This is a product",
    "price": 99.99
  },
  {
    "id": 2,
    "name": "Product 2",
    "description": "This is another product",
    "price": 89.99
  }
]
```

## API Endpoints

Below are the available API endpoints for managing products:

- `GET /api/products` - List all products.
- `POST /api/products` - Create a new product.
- `GET /api/products/{id}` - Get a specific product by its ID.
- `PUT /api/products/{id}` - Update a product by its ID.
- `DELETE /api/products/{id}` - Delete a product by its ID.

## Sample Data

For testing and development purposes, you can find a sample data CSV with 300 test products in the repository. Access the sample data here: [Sample Product Data](tests/data/sample_product_data.csv).

## Postman Collection

I've included the Postman Collection for testing the Laravel Products API. You can download it here: [Laravel Products API Postman Collection](tests/data/postman_collection.json).

## Support
If you find Laravel Products API useful and would like to support its development, consider making a donation:

- **Buy Me a Coffee:** Support on [Buy Me a Coffee](https://buymeacoffee.com/michaelharper)

Your contributions help ensure continued development and improvements to the extension.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
