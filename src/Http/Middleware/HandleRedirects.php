<?php

namespace Surgems\RedirectUrls\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Statamic\Support\Str;
use Surgems\RedirectUrls\Facades\Redirect;

class HandleRedirects 
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->status() !== 404 || ! config('statamic.redirect-urls.enable', true)) {
            return $response;
        }

        $url = Str::start($request->getRequestUri(), '/');
        $url = Str::substr(Str::finish($url, '/'), 0, -1);

        $this->cachedRedirects = Cache::get('statamic.redirect.redirect-urls', []);

        if (isset($this->cachedRedirects[$url])) {
            return redirect(
                $this->cachedRedirects[$url]['to'],
                $this->cachedRedirects[$url]['type'],
            );
        }

        if (! $redirect = Redirect::findByUrl($url)) {
            return $response;
        }

        $this->cachedRedirects[$url] = [
            'to' => $redirect->to(),
            'type' => $redirect->type(),
        ];

        Cache::put('statamic.redirect.redirect-urls', $this->cachedRedirects);

        try {
            return redirect($redirect->to(), $redirect->type());
        } catch (\Exception $e) {
            return $response;
        }
    }
}