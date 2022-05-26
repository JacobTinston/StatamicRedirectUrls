<?php

namespace Surgems\RedirectUrls\Controllers;

use Closure;
use Illuminate\Http\Request;
use Statamic\Exceptions\NotFoundHttpException;

use Statamic\Facades\OAuth;
use Statamic\Facades\Site;
use Statamic\Facades\URL;
use Statamic\Statamic;
use Statamic\Http\Controllers;
use Statamic\Http\Controllers\FrontendController;
use Statamic\Facades\Data;
use Statamic\Http\Responses\DataResponse;
use Statamic\Support\Arr;
use Statamic\Support\Str;
use Statamic\View\View;

global $ARRAY_OF_REDIRECTS;
$ARRAY_OF_REDIRECTS = include(__DIR__.'/../../../../../config/redirect-urls.php');

class RedirectController
{
    public function __construct()
    {
        $this->array_of_redirects = $GLOBALS['ARRAY_OF_REDIRECTS'];
    }

    public function index(Request $request)
    {
        route('redirect-url', ['slug' => ' ', 'extra' => ' ']);

        return $this;
    }

    public function createRedirect(Request $request, $slug = null, $extra = null)
    {
        if($extra) {
            $uri = '/'.$slug.'/'.$extra;
        } else {
            $uri = '/'.$slug;
        }

        foreach($this->array_of_redirects as $redirect_pair)
        {
            if($redirect_pair[0] === $uri) {
                return redirect($redirect_pair[1], 301);
            }
        }

        $url = Site::current()->relativePath($request->getUri());

        if (Statamic::isAmpRequest()) {
            $url = str_after($url, '/'.config('statamic.amp.route'));
        }

        if (Str::contains($url, '?')) {
            $url = substr($url, 0, strpos($url, '?'));
        }

        if (Str::endsWith($url, '/') && Str::length($url) > 1) {
            $url = rtrim($url, '/');
        }

        if ($data = Data::findByUri($url, Site::current()->handle())) {
            return $data;
        }

        throw new NotFoundHttpException;
    }
}