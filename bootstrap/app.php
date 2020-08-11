<?php

use Hashids\Hashids;

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();


$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();


$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->bind(Hashids::class, static fn(): Hashids => new Hashids(
    config('short_url')['salt'],
    config('short_url')['length'],
    config('short_url')['alphabet'],
));

$app->configure('app');
$app->configure('short_url');

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], static function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
