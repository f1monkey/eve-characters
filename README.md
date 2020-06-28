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

* Add client id, client secret and callback url of [your application](https://developers.eveonline.com/applications) to `.env.local`:
```yaml
EVE_ESI_CALLBACK_URL=http://localhost:8081/callback
EVE_ESI_CLIENT_ID=qwerty
EVE_ESI_CLIENT_SECRET=X9eHaXdUq9A9uesqhBP5fwQcnrS6Mkcy5H110Hirqwerty
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
