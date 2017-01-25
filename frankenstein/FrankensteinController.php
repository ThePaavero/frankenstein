<?php

namespace Frankenstein;

class FrankensteinController
{
    protected $api;

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        global $json_api;
        $this->api = $json_api;
    }

}
