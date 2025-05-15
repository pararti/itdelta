

# CRUD панель на Laravel

Реализация панели администрирования пользователей.

### Функционал:

- Список пользователей.

- Добавление пользователя

- Удаление пользователя

- Изменение пользователя. Карточка пользователя (ФИО, дата рождения, моб. телефон, E-mail, логин, пароль, фото)

## Первый запуск

1. ``composer install``
2. ``cp .env.example .env``
3. ``php artisan key:generate``
4. ``php artisan migrate:fresh --seed``
5. ``php artisan storage:link``
6. ``php artisan serve``

если есть проблемы с бд, нужно проверить наличие файла sqlite ``database/database.sqlite``
если отсуствует, то создать:
```bash
touch database/database.sqlite
```
после запуска панель будет доступна по адресу:
``localhost:8000/users``

_ручка для генерации csv:_
``localhost:8000/generate-products-csv``

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
