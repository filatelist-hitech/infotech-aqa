## Что проверяется

- отказ во входе с неверными данными;
- валидация пустой формы;
- `type="password"` у поля пароля;
- переход к восстановлению пароля.


## Структура

```text
.
├── composer.json
├── composer.lock
├── codeception.yml
├── tests/
│   ├── Acceptance.suite.yml
│   ├── Acceptance/LoginCest.php
│   └── Support/
│       ├── AcceptanceTester.php
│       ├── Helper/UserDbHelper.php
│       └── Page/LoginPage.php
├── examples/create_user_api.php
├── docs/known-bugs.md
└── docs/additional-login-scenarios.md
```

`tests/Support/_generated/` создаётся командой `codecept build` и не хранится в Git.

## Запуск

Нужны PHP 8.2+, Composer, Chrome и WebDriver endpoint `127.0.0.1:4444`. На этом endpoint должен быть запущен ChromeDriver с URL base `/wd/hub` или Selenium Server.

```bash
git clone https://github.com/filatelist-hitech/infotech-aqa.git
cd infotech-aqa
composer install
composer test
```

`composer test` сначала собирает actor, затем запускает suite. Те же шаги вручную:

```bash
vendor/bin/codecept build
vendor/bin/codecept run Acceptance
```

Base URL, браузер и WebDriver endpoint заданы в `tests/Acceptance.suite.yml`.


## Тестовые данные и примеры


`UserDbHelper` демонстрирует `Db::haveInDatabase()`, но не подключён к suite: в репозитории нет DB credentials и не выполняются записи в БД. Таблица и колонки в helper условные. Метод требует hash в формате приложения; `haveInDatabase()` передаёт значения параметрами и очищает добавленную запись после теста.

`examples/create_user_api.php` показывает POST с Bearer auth, JSON body, проверкой HTTP 201 и ответа. Перед запуском нужно сверить путь и схему с OpenAPI.


## Дополнительные кейсы и найденные баги 

Дополнительные кейсы для проверки - ./docs/additional-login-scenarios.md

Найденные баги - ./docs/known-bugs.md
