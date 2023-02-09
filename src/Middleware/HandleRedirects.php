<?php

namespace Surgems\RedirectUrls\Middleware;

use Closure;
use Illuminate\Http\Request;
use Statamic\Exceptions\NotFoundHttpException;
use Surgems\RedirectUrls\Controllers\RedirectController;

class HandleRedirects
{
    public function handle(Request $request, Closure $next)
    {
        if(config('statamic.redirect-urls.enable', true))
        {
            $response = $next($request);
            $controller = new RedirectController();

            if($response->status() === 404) 
            {
                $redirect = $controller->createRedirect($request);

                if(!$redirect) throw new NotFoundHttpException;

                $uri = $redirect[0];
                $redirect_type = $redirect[1];

                return redirect($uri, $redirect_type);
            }

            $uri = $controller->formatUrl('/'.$request->path());
            $current_path = \Request::getPathInfo();

            if($current_path !== '/' && $current_path !== $uri) {
                return redirect($uri, 301);
            }
        }

        return $next($request);
    }
}