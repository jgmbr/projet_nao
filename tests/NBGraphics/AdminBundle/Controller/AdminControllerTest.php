<?php

/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 27/02/2017
 * Time: 18:35
 */

namespace tests\NBGraphics\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testIsNotGranted()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/index');

        $this->assertFalse($client->getResponse()->isSuccessful());
    }
}