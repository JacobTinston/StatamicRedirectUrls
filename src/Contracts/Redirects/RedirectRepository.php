<?php

namespace Surgems\RedirectUrls\Contracts\Redirects;

interface RedirectRepository
{
    public function all();

    public function find($id);

    public function findByUri(string $uri);

    public function make();

    public function query();

    public function save($entry);

    public function delete($entry);
}
