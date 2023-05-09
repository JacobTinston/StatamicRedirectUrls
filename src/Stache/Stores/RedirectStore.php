<?php

namespace Surgems\RedirectUrls\Stache\Stores;

use Statamic\Facades\YAML;
use Statamic\Stache\Stores\BasicStore;
use Surgems\RedirectUrls\Facades\Redirect;

class RedirectStore extends BasicStore
{
    public function key()
    {
        return 'redirect-urls';
    }

    public function makeItemFromFile($path, $contents)
    {
        $data = YAML::file($path)->parse($contents);

        $redirect = Redirect::make()
            ->id(array_pull($data, 'id') ?? app('stache')->generateId())
            ->from(array_pull($data, 'From'))
            ->to(array_pull($data, 'To'))
            ->type(array_pull($data, 'Type'))
            ->active(true);

        $redirect->save();

        return $redirect;
    }
}
