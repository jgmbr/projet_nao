<?php

/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 27/02/2017
 * Time: 16:32
 */

namespace tests\NBGraphics\FrontSiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ContactControllerTest extends WebTestCase
{
    public function testContactForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contactez-nous');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Envoyer votre message', $client->getResponse()->getContent());
        $this->assertCount(1, $crawler->filter('button'));



        $buttonCrawlerNode = $crawler->selectButton('Envoyer votre message');
        $form = $buttonCrawlerNode->form([
            'contact_form[firstName]' => 'Thomas',
            'contact_form[lastName]' => 'Dimnet',
            'contact_form[emailAddress]' => 'thomas.dimnet@gmail.com',
            'contact_form[message]' => 'Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.',
            'contact_form[captcha]' => 'xxxxxx,x'
        ]);


        $this->assertFalse($client->isFollowingRedirects());

    }
}