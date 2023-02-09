<?php

namespace Surgems\RedirectUrls;

use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;
use Statamic\Facades\CP\Nav;
use Surgems\RedirectUrls\Middleware\HandleRedirects;

class ServiceProvider extends AddonServiceProvider
{
    protected $middlewareGroups = [
        'statamic.web' => [
            HandleRedirects::class
        ],
    ];

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    public function bootAddon()
    {
        $this->createDatabase()
             ->bootAddonConfig()
             ->bootAddonNav()
             ->bootAddonViews();
    }

    protected function createDatabase()
    {
        $location = 'redirect-urls/database';

        if (! file_exists(public_path($location))) {
            mkdir(public_path($location), 0777, true);
        }

        if (! file_exists(public_path($location . '/redirect-urls.yaml'))) {
            fopen(public_path($location . '/redirect-urls.yaml'), 'c+');
        }

        return $this;
    }

    protected function bootAddonConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'statamic.redirect-urls');

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

    protected function bootAddonViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'redirect-urls');

        return $this;
    }
}
