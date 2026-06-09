<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
    App\Providers\NotificationServiceProvider::class,
    NotificationChannels\WebPush\WebPushServiceProvider::class,
];
