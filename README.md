# Socialite Providers for Backlog

use laravel/.env  or config/service.php

```
BACKLOG_KEY=your_key
BACKLOG_SECRET=your_secret
BACKLOG_REDIRECT_URI=http://localhost:8000/login/backlog/callback
BACKLOG_SPACE_URI=https://your-space-id.backlog.jp/
```



## install using composer

```json
  "repositories": [
    {
      "type":"vcs",
      "url": "https://github.com/takuya/SocialiteBacklogProvider.git"
    }
  ],
  "require": {
    "socialiteproviders/backlog": "dev-master"
  },
```

## use ing laravel event
Add reference to app/Providers/EventServiceProvider.php
```php
  protected $listen = [
    'App\Events\Event' => [
      'App\Listeners\EventListener',
    ],
    // add for oauth 
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
      // add your listeners (aka providers) here
      'SocialiteProviders\\Backlog\\BacklogExtendSocialite@handle',
    ],

```


