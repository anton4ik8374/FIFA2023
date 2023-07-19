<?php

namespace App\Services;

interface InterfaceServices
{
    /**
     * @return void
     */
    public function load() : void;

    public function import(string $uuid, int $event_id) : bool;

    public function constructorData(int $event_id) : void;
}
