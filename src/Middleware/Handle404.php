<?php

namespace Surgems\RedirectUrls\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Data;
use Statamic\Facades\Site;
use Statamic\Exceptions\NotFoundHttpException;
use Surgems\RedirectUrls\Controllers\RedirectController;

class Handle404
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $controller = new RedirectController();

        if(config('statamic.redirect-urls.enable', true) && $response->status() === 404) {
            $uri = $controller->createRedirect($request);

            if(! $uri)
            {
                throw new NotFoundHttpException;
            }

            return redirect($uri, 301);
        }

        if(config('statamic.redirect-urls.enable', true) && $response->status() !== 404) {
            $uri = $controller->formatStr('/'.$request->path());

            if(\Request::getPathInfo() === '/')
            {
                return $response;
            }

            if(\Request::getPathInfo() !== $uri) {
                return redirect($uri, 301);
            }
        }

        return $response;
    }
}