<?php

namespace App\Services;

interface InterfaceServices
{
    /**
     * @return void
     */
    public function load() : void;

    public function import($uuid) : void;
}
