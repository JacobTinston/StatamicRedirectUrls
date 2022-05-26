<?php

namespace Surgems\RedirectUrls\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Surgems\RedirectUrls\Controllers\RedirectController;

class Handle404
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if(config('statamic.redirect-urls.enable', true) && $response->status() === 404) {
            $controller = new RedirectController();
            $controller->index($request);
        }

        return $response;
    }
}