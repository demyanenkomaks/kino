## Разработка ведеться

| Service | Version |
|---------|---------|
| mysql   | 8.0.27  |
| php     | 8.3     |

## Разворачивание проекта

1. Клонируем проект `git clone ...`
2. Копируем `.env.example` в `.env`
3. Указываем настройки в файле `.env` описание смотреть `.env.example`
4. Генерируем ключ приложения `php artisan key:generate`
5. Устанавливаем пакеты Composer `composer install --no-dev`
6. Запускаем миграции `php artisan migrate`
7. Создание симолический ссылок `php artisan storage:link`
8. Готово!


В случае возникновения ошибок с кешом:
```
php artisan optimize:clear // Очищаем кеш laravel
php artisan filament:optimize-clear // Очищаем кеш filament

php artisan optimize // Создаем кеш laravel
php artisan filament:optimize // Создаем кеш filament
```
