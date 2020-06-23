# eve-characters
![](https://github.com/f1monkey/eve-characters/workflows/Tests/badge.svg) ![](https://img.shields.io/github/v/tag/f1monkey/eve-characters)

Character list microservice based on RoadRunner and Symfony.

## Docs

Auto-generated API documentation located at /v1/doc route.

## Development

* Copy `docker-compose.override.yml.dist` to `docker-compose.override.yml`
```
cp docker-compose.override.yml.dist docker-compose.override.yml
```
* Run docker containers
```
$ docker-compose up -d
```
* Connect to php container
```
$ docker-compose exec php bash
```
* Copy `config/jwt/public.pem` from [auth](https://github.com/f1monkey/auth) service to `config/jwt` folder
## Testing
Run static analyse
```
$ vendor/bin/phpstan analyze --level=max src
```

Run tests:
```
$ vendor/bin/codecept run
```
