## Get Started

1. composer install
2. cp .env.example .env
3. php artisan migrate
4. php artisan db:seed --class=IndicatorTableSeeder
5. php artisan serve
5. Go to list submissions
```
http://localhost:8000/api/user/submissions?page=n
```
> n = 1 sampai dengan 6