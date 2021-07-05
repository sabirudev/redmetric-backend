## Get Started

1. composer install
2. cp .env.example .env
3. php artisan migrate
4. php artisan db:seed --class=IndicatorTableSeeder
5. php artisan passport:install
6. php artisan serve


## List API

1. GET  | List Submission (http://localhost:8000/api/user/submissions?page=n)
2. POST | Submit Submission (http://localhost:8000/api/user/submissions)
