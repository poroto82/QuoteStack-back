# Laravel Quote Stack

A simple Laravel rest api project that retrieves and manages quotes from the ZenQuotes API. It uses laravel passport for authentication

## Installation

1. Clone the repository:

```bash
git clone https://github.com/poroto82/QuoteStack-back.git
cd laravel-quote-stack

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan passport:install

php artisan serve
```

## API Endpoints
GET /api/quotes: Retrieve quotes. Optional parameters: mode (default is 'quotes'), limit (default is 5), forceRefresh (default is false).

GET /api/user/quotes: Retrieve quotes for the authenticated user.

POST /api/user/quotes: Save a new quote for the authenticated user. Requires text and author in the request body.

DELETE /api/user/quotes/{id}: Delete a quote for the authenticated user.

## Contributing
Feel free to contribute by opening issues or pull requests. Any contributions are welcome!

## Acknowledgments

This project utilizes the ZenQuotes API to fetch inspiring quotes. We would like to express our gratitude to ZenQuotes for providing this service.

- [ZenQuotes](https://zenquotes.io/)

## License
This project is open-sourced under the MIT license.