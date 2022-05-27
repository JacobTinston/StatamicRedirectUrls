<?php

namespace Surgems\RedirectUrls\Controllers;

use Closure;
use Illuminate\Http\Request;
use Statamic\Facades\OAuth;
use Statamic\Facades\URL;
use Statamic\Statamic;
use Statamic\Facades\Site;
use Statamic\Http\Controllers;
use Statamic\Http\Controllers\FrontendController;
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

    public function createRedirect(Request $request)
    {
        $uri = $this->formatStr('/'.$request->path());

        foreach($this->array_of_redirects as $redirect_pair)
        {
            if($redirect_pair[0] === $uri) {
                return $redirect_pair[1];
            }
        }

        return false;
    }

    public function formatStr($str)
    {
        if (Statamic::isAmpRequest()) {
            $str = str_after($str, '/'.config('statamic.amp.route'));
        }

        if (Str::contains($str, '?')) {
            $str = substr($str, 0, strpos($str, '?'));
        }

        if (Str::endsWith($str, '/') && Str::length($str) > 1) {
            $str = rtrim($str, '/');
        }

        return $str;
    }
}