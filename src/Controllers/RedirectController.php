<?php

namespace Surgems\RedirectUrls\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

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

        $redirects_array = Yaml::parseFile($this->import_path) ? Yaml::parseFile($this->import_path) : array();

        $this->array_of_redirects = $redirects_array;

        return $this->array_of_redirects;
    }

    public function createRedirect(Request $request)
    {
        $current_uri = $this->formatUrl('/'.$request->path());

        if(count($this->array_of_redirects) > 0)
        {
            foreach($this->array_of_redirects as $redirect)
            {
                $from_uri = $this->formatUrl($redirect[0]);
                $to_uri = $this->formatUrl($redirect[1]);
                $redirect_type = array_key_exists(2, $redirect) ? intval($redirect[2]) : 301;

                if($from_uri === $current_uri) {
                    return array($to_uri, $redirect_type);
                }
            }
        }

        return null;
    }

    public function formatUrl($url)
    {
        if(Str::contains($url, 'http://'))
        {
            $prefix = 'http://'.$_SERVER['HTTP_HOST'];
            $url = str_replace($prefix, '', $url);
        }

        if(Str::contains($url, 'https://'))
        {
            $prefix = 'https://'.$_SERVER['HTTP_HOST'];
            $url = str_replace($prefix, '', $url);
        }

        if(Str::contains($url, '?')) 
        {
            $url = substr($url, 0, strpos($url, '?'));
        }

        if(Str::endsWith($url, '/') && Str::length($url) > 1) 
        {
            $url = rtrim($url, '/');
        }

        return $url;
    }
}