### ExchangeRate API
Rename the file .env.example to .env

```
mv .env.example .env
```

and then set your API Key in .env file

### Installation & Run

Run

```
docker compose up
```

### Tests

Connect to container and run

```
vendor/bin/phpunit tests
```