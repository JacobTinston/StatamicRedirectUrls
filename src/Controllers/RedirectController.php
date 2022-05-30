<?php

namespace Surgems\RedirectUrls\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;
use Statamic\Statamic;
use Statamic\Support\Str;

class RedirectController
{
    public function __construct()
    {
        $this->import_path = public_path('redirect-urls/database/redirect-urls.yaml');
        $this->array_of_redirects = $this->setArrayOfRedirects();
    }

    public function setArrayOfRedirects($array = null)
    {
        if($array)
        {
            $yaml = Yaml::dump($array);
            file_put_contents($this->import_path, $yaml);
        }

        $redirects_array = Yaml::parseFile($this->import_path);

        $this->array_of_redirects = $redirects_array;

        return $this->array_of_redirects;
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