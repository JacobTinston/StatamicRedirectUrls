<?php

namespace Surgems\RedirectUrls\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Surgems\RedirectUrls\Facades\Redirect;
use Symfony\Component\Yaml\Yaml;

class RedirectController
{
    public function update()
    {
        //
    }

    public function delete(Request $request)
    {
        Redirect::find($request->id)->delete();

        session()->flash('success', 'Redirect deleted successfully.');

        Cache::forget('statamic.redirect.redirect-urls');

        return redirect()->action(DashboardController::class);
    }
}