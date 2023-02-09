<?php

namespace Surgems\RedirectUrls\Controllers;

use Surgems\RedirectUrls\Controllers\RedirectController;

class DashboardController extends RedirectController
{
    public function __invoke()
    {
        $redirects = $this->array_of_redirects ? $this->array_of_redirects : array();

        return view('redirect-urls::dashboard', ['redirects' => $redirects]);
    }
}
