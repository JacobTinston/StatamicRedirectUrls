<?php

namespace Surgems\RedirectUrls\Controllers;

use Symfony\Component\Yaml\Yaml;
use Surgems\RedirectUrls\Controllers\RedirectController;

class DashboardController extends RedirectController
{
    public function __invoke()
    {
        return view('redirect-urls::dashboard', ['redirects' => Yaml::parseFile($this->import_path)]);
    }
}
