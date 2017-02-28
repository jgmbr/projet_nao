<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 28/02/2017
 * Time: 10:34
 */

namespace tests\NBGraphics\AdminBundle\Controller;


class AdminControllerTest extends AbstractControllerTest
{
    /**
     * When a client is authenticated
     */
    public function testIndexAction()
    {
        $crawler = $this->client->request('GET', '/soumettre-une-observation');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}