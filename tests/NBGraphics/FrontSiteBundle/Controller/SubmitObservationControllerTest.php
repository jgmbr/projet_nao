<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 27/02/2017
 * Time: 18:11
 */

namespace tests\NBGraphics\FrontSiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubmitObservationControllerTest extends WebTestCase
{
    /*
     * If the user is not connected
     */
    public function testIsNotGranted()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/soumettre-une-observation');

        $this->assertFalse($client->getResponse()->isSuccessful());
    }


    
}