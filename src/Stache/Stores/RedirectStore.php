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

        if (! $id = array_pull($data, 'id')) {
            $idGenerated = true;
            $id = app('stache')->generateId();
        }

        $redirect = Redirect::make()
            ->id($id)
            ->from(array_pull($data, 'from'))
            ->to(array_pull($data, 'to'))
            ->type(array_pull($data, 'type'))
            ->active(true);

        if (isset($idGenerated)) {
            $redirect->save();
        }

        return $redirect;
    }
}
