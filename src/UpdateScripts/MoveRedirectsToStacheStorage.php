<?php

namespace Surgems\RedirectUrls\UpdateScripts;

use Statamic\Facades\YAML;
use Statamic\UpdateScripts\UpdateScript;
use Surgems\RedirectUrls\Facades\Redirect;

class MoveRedirectsToStacheStorage extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldversion)
    {
        return $this->isUpdatingTo('2.1.0');
    }

    public function update()
    {
        $import_path = public_path('redirect-urls/database/redirect-urls.yaml');
        $redirects = Yaml::file($import_path)->parse() ?? [];

        if (count($redirects)) {
            foreach ($redirects as $redirect) {
                if (! Redirect::query()->where('from', $redirect[0])->first()) {
                    $stached_redirect = Redirect::make()
                        ->from($redirect[0])
                        ->to($redirect[1])
                        ->type($redirect[2])
                        ->active(true);

                    $stached_redirect->save();
                }
            }
        }

        $this->console()->info('Redirects moved to stache storage');
    }
}
