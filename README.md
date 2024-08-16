
# Crypto Backend

API на Laravel для бота и клиентской части. 


## Installation

Установка стандартная. Для удобства написан Dockerfile и docker-compose.yml

```bash
  npm install
  composer install
  cp .env.example .env
```
    
## Documentation

В проекте реализовано:

 * Слой DTO c помощью библиотеки от [Spatie](https://github.com/spatie/data-transfer-object)
 * Работа с Enum с помощью библиотеки от [BenSampo](https://github.com/BenSampo/laravel-enum)
 * Jwt авторизация с помощью библиотеки о [Tymon](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/)
 * Шаблон фильтра
 * Сервисный слой
 * Слой контрактов
 * Feature тесты
 * Собственная настрйка контейнеризации приложения и нужных сервисов
 * CRUD сущностей
 * Получение курса валют с помощью API Binance
 * Для тестирования написаны фабрики и сидеры. 


## Usage/Examples

Наполнение БД тестовыми данными 
```
php artisan db:seed
```

