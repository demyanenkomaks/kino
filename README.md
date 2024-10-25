## Разработка ведеться

| Service | Version |
|---------|---------|
| mysql   | 8.0.27  |
| php     | 8.3     |

## Разворачивание проекта

1. Клонируем проект
2. Копируем `.env.example` в `.env`
3. Указываем настройки в файле `.env` `APP_...`, `DB_...`
4. Устанавливаем пакеты Composer
```
composer install --no-dev
```
5. Запускаем миграции
```
php artisan migrate
```
6. Создание симолический ссылок
```
php artisan storage:link
```
7. Готово!


В случае возникновения ошибок с кешом:
```
1. php artisan optimize:clear // Очищаем кеш laravel
2. php artisan filament:optimize-clear // Очищаем кеш filament

3. php artisan optimize // Создаем кеш laravel
4. php artisan filament:optimize // Создаем кеш filament
```
