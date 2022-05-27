<?php

namespace Surgems\RedirectUrls;

use Statamic\Providers\AddonServiceProvider;
use Surgems\RedirectUrls\Middleware\Handle404;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $middlewareGroups = [
        'web' => [
            Handle404::class
        ],
    ];

    public function bootAddon()
    {
        $this->registerAddonConfig();

        Statamic::afterInstalled(function ($command) {
            $file_path = 'config/redirect-urls.php';
            $template = include(__DIR__.'/templates/redirect-urls-array.php');

            if(! file_exists($file_path))
            {
                file_put_contents($file_path, $template);
            }

            return $this;
        });
    }

    protected function registerAddonConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'statamic.redirect-urls');

        return $this;
    }
}
