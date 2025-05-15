

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


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
