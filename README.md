Simple php json api

Вимоги:
- PHP >= 8.1
- Composer
- PHPUnit

Встановлення:
- composer install
- php -S localhost:8000 -t public

API буде доступний за адресою http://localhost:8000/api.php

Приклад запиту:

```
curl -X POST http://localhost:8000/api.php \
     -H "Content-Type: application/json" \
     -d '{
           "source": "test_source",
           "payload": {
               "email": "test@mail.com",
               "data": "sample data"
           }
         }'
```

Очікувана відповідь:
```
{
    "status": "success"
}
```

Збережені дані у logs/data.json:
```
{
    "source": "test_source",
    "payload": {
        "email": "_SENSITIVE_DATA_REMOVED_",
        "data": "sample data"
    },
}
```