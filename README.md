# test-for-candidates

Изначально вел разработку предметной области приложения и только потом вышел на уровень Middleware Symfony. Поэтому некоторые проверки и валидация уже являются неотъемлемой частью бизнес-логики.

В моей реализации товары и купоны находятся во внутренней памяти приложения. Композиция бизнес-логики приложения позволяет добавлять другие источники данных(СУБД или сторонний микросервис по REST API).
Например, для MySQL через Doctrine, Entity должна будет реализовывать соответствующий интерфейс.

Покрыл несколькими видами тестов малую часть предметной области бизнес-логики как пример.

В сборке docker используется веб-сервер Symfony. Это было сделано для демонстрации и экономии времени. Это же касается и СУБД.

Для сборки и запуска приложения необходимо выполнить:
>docker build -t test_from_viktor .\
>docker run -p:8866:8000 --rm test_from_viktor

Примеры запроса данных:
>curl -d '{"product":"1", "taxNumber":"GR123456789", "couponCode":"CS002"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8866/calculate-price \

>curl -d '{"product":"1", "taxNumber":"GR123456789"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8866/calculate-price

>curl -d '{"product":"1", "taxNumber":"GR12"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8866/calculate-price

>curl -d '{"product":"1", "taxNumber":"GR123456789", "couponCode":"CS002", "paymentProcessor":"paypal"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8866/purchase

>curl -d '{"product":"1", "taxNumber":"GR123456789", "couponCode":"CS002", "paymentProcessor":"stripe"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8866/purchase

>curl -d '{"product":"1", "taxNumber":"GR123456789", "couponCode":"CS002", "paymentProcessor":"yandex"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8866/purchase

>curl -d '{"product":"1", "taxNumber":"GR123456789", "paymentProcessor":"stripe"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8866/purchase

>curl -d '{"product":"4", "taxNumber":"GR123456789", "paymentProcessor":"stripe"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8866/purchase 