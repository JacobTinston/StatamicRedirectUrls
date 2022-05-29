<?php

namespace Surgems\RedirectUrls;

use Statamic\Providers\AddonServiceProvider;
use Surgems\RedirectUrls\Middleware\Handle404;
use Statamic\Statamic;
use Statamic\Facades\CP\Nav;

class ServiceProvider extends AddonServiceProvider
{
    protected $middlewareGroups = [
        'statamic.web' => [
            Handle404::class
        ],
    ];

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    public function bootAddon()
    {
        $this->registerAddonConfig();
        $this->bootAddonViews();
        $this->bootAddonNav();
    }

    protected function registerAddonConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'statamic.redirect-urls');

        return $this;
    }

    protected function bootAddonViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'redirect-urls');

        return $this;
    }


    protected function bootAddonNav()
    {
        Nav::extend(function ($nav) {
            $nav->tools('Redirect Urls')
                ->route('redirect-urls.dashboard')
                ->icon('git')
                ->children([
                    'Import Redirects' => cp_route('redirect-urls.import'),
                ]);
        });

        return $this;
    }
}
