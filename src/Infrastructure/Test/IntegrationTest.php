<?php

namespace App\Infrastructure\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IntegrationTest extends WebTestCase
{
    public static function createClient(array $options = [], array $server = [])
    {
        return parent::createClient(array_merge($options, ["environment" => "integration"]), $server);
    }
}
