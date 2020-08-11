## How To Use
```bash
# Clone this repository
$ git clone https://github.com/DroneZzZko/url_shortener.git

# Go into the repository
$ cd url_shortener

# Run the app
$ docker-compose up -d

# Install dependencies
$ docker-compose exec app composer install

# Apply DB migrations
$ docker-compose exec app php artisan migrate

# Run unit tests
$ docker-compose exec app composer exec phpunit -v

# Make an API call to get short url
$ curl -X POST 'http://localhost:8080' -F 'url=https://google.com/'
```
