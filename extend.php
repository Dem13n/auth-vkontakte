<?php

use Dem13n\Auth\Vkontakte\VkontakteAuthController;
use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Locales(__DIR__ . '/resources/locale')),

    (new Extend\Routes('forum'))
        ->get('/auth/vkontakte', 'auth.vkontakte', VkontakteAuthController::class),
];
